/**
 * @typedef {Object} Post
 * @property {number} ID
 * @property {string} comment_count
 * @property {string} comment_status
 * @property {string} filter
 * @property {string} guid
 * @property {number} menu_order
 * @property {string} meta_id
 * @property {string} meta_key
 * @property {string} meta_value
 * @property {string} ping_status
 * @property {string} pinged
 * @property {string} post_author
 * @property {string} post_content
 * @property {string} post_content_filtered
 * @property {string} post_date
 * @property {string} post_date_gmt
 * @property {string} post_excerpt
 * @property {string} post_id
 * @property {string} post_mime_type
 * @property {string} post_modified
 * @property {string} post_modified_gmt
 * @property {string} post_name
 * @property {number} post_parent
 * @property {string} post_password
 * @property {string} post_status
 * @property {string} post_title
 * @property {string} post_type
 * @property {string} to_ping
 */

class Material {
  scope;
  store = {
    select: "",
    edit: -1,
  };
  state = {
    loading: true,
    id: [],
    category: [],
    pages: [],
  };
  pageId = "";
  items = [];

  constructor(scope) {
    this.scope = scope;
  }

  addItem() {
    this.items.push({});
  }
  editItem(index) {
    this.store.edit = index;
  }
  removeItem(index) {
    if (confirm(`ต้องการลบ "#${index + 1}" หรือไม่?`)) {
      this.items.splice(index, 1);
    }
  }

  addToItem(from, index) {
    const item = this.state[from].find(
      (i) => `${i.value}` === `${this.store.select}`
    );
    if (item) {
      this.items[index].items = (this.items[index].items || []).concat({
        id: item.value,
        label: item.label,
      });
      this.store.select = "";
    }
  }
  removeItemItems(itemIndex, itemsIndex) {
    this.items[itemIndex].items.splice(itemsIndex, 1);
  }

  async get(action, data) {
    return await fetch(ajaxurl + `?action=${action}${data || ""}`).then((res) =>
      res.json()
    );
  }

  async save() {    
    const result = await jQuery.post(ajaxurl, {
      action: "material_update",
      data: {
        id: this.pageId,
        value: angular.toJson(this.items),
      },
    })
    if(typeof result === "number"){
      alert('Saved')
    }
    console.log(result);
  }

  /**
   * @returns {Promise<Array<Post>>}
   */
  async getLink() {
    return await this.get("material_page_list");
  }

  async pageChange() {
    const result = await this.get("material_page_data", `&id=${this.pageId}`);
    const data = JSON.parse(result)
    this.items = Array.isArray(data) ? data : [];
    console.log(data)
    this.scope.$apply();
  }

  async init() {
    const { posts, categories, pages } = await this.getLink();
    this.state = {
      id: posts.map((post) => ({ label: post.post_title, value: post.ID })),
      category: categories.map((cat) => ({
        label: cat.name,
        value: cat.cat_ID,
      })),
      pages,
      loading: false,
    };

    this.scope.$apply();
  }
}
