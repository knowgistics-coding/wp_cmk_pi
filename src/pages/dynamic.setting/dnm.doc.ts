export class DNMDoc {
  label: string = "";
  value: number = 0;

  constructor(data?: Partial<DNMDoc>) {
    Object.assign(this, data);
  }

  Label() {
    return `${DNMDoc.strip_tags(this.label)} (ID: ${this.value})`;
  }

  // @ts-ignore
  private static url: string = cmk_pi.ajaxurl;

  static strip_tags = (input: string) => {
    return input.replace(/(<([^>]+)>)/gi, "");
  };

  static getPages() {
    return new Promise<DNMDoc[]>((resolve, reject) => {
      fetch(`${this.url}?action=dynamic_page_list`)
        .then((res) => res.json())
        .then((res) => {
          const docs = res
            .map((doc) => new DNMDoc(doc))
            .sort((a, b) => a.label.localeCompare(b.label));
          resolve(docs);
        })
        .catch(reject);
    });
  }

  static loadPage(id: number) {
    return new Promise<DNMSection[]>((resolve, reject) => {
      fetch(`${this.url}?action=dynamic_page_load&data=${id}`)
        .then((res) => res.json())
        .then((res) => {
          const docs = res.map(
            (doc) => new DNMSection({ ...doc.value, id: doc.id })
          );
          resolve(docs);
        })
        .catch(reject);
    });
  }

  static loadItems() {
    return new Promise<
      Record<"page" | "category" | "id", { label: string; value: number }[]>
    >((resolve, reject) => {
      fetch(`${this.url}?action=dynamic_items_load`)
        .then((res) => res.json())
        .then(async (res) => {
          const page = await DNMDoc.getPages();
          resolve({ ...res, page });
        })
        .catch(reject);
    });
  }
}

export class DNMSection {
  id: string = "";
  num: string = "-1";
  type: string = "slide";
  from: string = "category";
  orderby: string = "";
  order: string = "";
  items: Record<"id" | "label", string>[] = [];
  label: string = "";

  constructor(data?: Partial<DNMSection & { orderBy: string }>) {
    this.id = data?.id ?? "";
    this.num = data?.num ?? "-1";
    this.type = data?.type ?? "slide";
    this.from = data?.from ?? "category";
    this.orderby = data?.orderby ?? data?.orderBy ?? "post_date";
    this.order = data?.order ?? "desc";
    this.items = data?.items ?? [];
    this.label = data?.label ?? "";
  }

  Set<T extends keyof this>(
    key: T,
    value: this[T],
    clearitems?: boolean
  ): DNMSection {
    if (clearitems) {
      return new DNMSection({ ...this, [key]: value, items: [] });
    } else {
      return new DNMSection({ ...this, [key]: value });
    }
  }

  Item() {
    return {
      add: (doc: { label: string; value: number }): DNMSection =>
        new DNMSection({
          ...this,
          items: this.items.concat({ label: doc.label, id: `${doc.value}` }),
        }),
      remove: (id: string): DNMSection =>
        new DNMSection({
          ...this,
          items: this.items.filter((item) => item.id !== id),
        }),
    };
  }

  Save() {
    return new Promise<boolean>((resolve, reject) => {
      const rawdata = this.Value();
      DNMSection.update(this.id, rawdata).then(resolve).catch(reject);
    });
  }

  Value() {
    return Object.entries(this)
      .filter(
        ([key, value]) =>
          value instanceof Function === false && ["id"].includes(key) === false
      )
      .reduce(
        (prev, [key, value]) => Object.assign(prev, { [key]: value }),
        {}
      );
  }

  Remove(pageId: number) {
    return new Promise<DNMSection[]>((resolve, reject) => {
      const data = new FormData();
      data.append("action", "dynamic_panel_remove");
      data.append("id", this.id);
      fetch(DNMSection.url, {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then(async () => {
          const sections = await DNMDoc.loadPage(pageId);
          resolve(sections);
        })
        .catch(reject);
    });
  }

  // @ts-ignore
  private static url: string = cmk_pi.ajaxurl;

  static add(id: string) {
    return new Promise<DNMSection[]>((resolve, reject) => {
      const data = new FormData();
      data.append("action", "dynamic_panel_add");
      data.append("id", id);
      data.append("value", JSON.stringify(new DNMSection().Value()));
      fetch(this.url, {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then(async () => {
          const sections = await DNMDoc.loadPage(parseInt(id));
          resolve(sections);
        })
        .catch(reject);
    });
  }

  static update(id: string, value: any) {
    return new Promise<boolean>((resolve, reject) => {
      const data = new FormData();
      data.append("action", "dynamic_panel_update");
      data.append("id", id);
      data.append("value", JSON.stringify(value));
      fetch(this.url, {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((res) => resolve(res))
        .catch(reject);
    });
  }
}
