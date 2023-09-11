import { Post } from "./post";

export type DNMSectionItem = Record<"id" | "label", string>;
export type DNMSectionType =
  | "slide"
  | "text"
  | "card"
  | "cover"
  | "square"
  | "cardslide"
  | "highlight"
  | "jpaenc";

declare global {
  interface Window {
    apiurl: string;
  }
}

export class DNMSection {
  from: "id" | "category" = "id";
  items: DNMSectionItem[] = [];
  num: string = "0";
  order: "asc" | "desc" = "desc";
  orderBy: string = "post_modified";
  type: DNMSectionType = "slide";
  label: string = "";

  constructor(data?: Partial<DNMSection>) {
    Object.assign(this, data);
  }

  async query():Promise<Post[]> {
    const items = (
      await Promise.all(
        this.items.map((item) => DNMSection.get(item.id, this.from))
      )
    )
      .reduce((acc, val) => acc.concat(val), [])
      .sort((a, b) => {
        const [x, y] = this.order === "asc" ? [a, b] : [b, a];
        if (typeof x?.[this.orderBy] === "string") {
          return x[this.orderBy].localeCompare(y[this.orderBy]);
        } else {
          return (x[this.orderBy] as number) - (y[this.orderBy] as number);
        }
      });
    console.log(items)
    return items;
  }

  static get(id: string, from: "id" | "category" = "id"): Promise<Post[]> {
    const url =
      from === "id"
        ? `${window.apiurl}/posts/${id}?_embed`
        : `${window.apiurl}/posts?categories=${id}&_embed`;
    console.log(url)
    return fetch(url)
      .then((res) => res.json())
      .then((res) => {
        if (Array.isArray(res)) {
          return res.map((item) => new Post(item));
        } else {
          return [new Post(res)];
        }
      });
  }
}
