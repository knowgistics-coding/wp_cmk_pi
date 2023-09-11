import { DNMSection } from "./dnm.doc";

export type DNMStateAction =
  | { type: "page"; value: number }
  | { type: "section"; value: DNMSection[] }
  | { type: "expanded"; index: number; value: boolean }
  | {
      type: "list";
      value: Record<
        "page" | "category" | "id",
        { label: string; value: number }[]
      >;
    };

export class DNMState {
  page: number = 0;
  sections: DNMSection[] = [];
  expanded: number = 0;
  list: Record<"page" | "category" | "id", { label: string; value: number }[]> =
    {
      page: [],
      category: [],
      id: [],
    };

  constructor(data?: Partial<DNMState>) {
    Object.assign(this, data);
  }

  PreviewLink(): string {
    const page = this.list.page.find((p) => `${p.value}` === `${this.page}`);
    return page ? `/?p=${page.value}` : ``;
  }

  Current() {
    return {
      post: () => this.list.page.find((p) => `${p.value}` === `${this.page}`),
      link: (): string => {
        const page = this.Current().post();
        return page ? `/?p=${page.value}` : ``;
      },
      label: (): string => {
        const page = this.Current().post();
        return page ? page.label : ``;
      },
    };
  }

  static reducer(s: DNMState, action: DNMStateAction) {
    switch (action.type) {
      case "page":
        return new DNMState({ ...s, page: action.value });
      case "section":
        return new DNMState({ ...s, sections: action.value });
      case "expanded":
        return new DNMState({
          ...s,
          expanded: action.value ? action.index : -1,
        });
      case "list":
        return new DNMState({ ...s, list: action.value });
      default:
        throw new Error();
    }
  }
}
