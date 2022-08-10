class Dynamic {
  loading = true;
  page = "";
  pages = [];
  panels = [];
  editIndex = false;
  editValue = null;
  editItemSelect = "";
  items = {
    category: [],
    id: [],
  };

  constructor(apply) {
    this.apply = apply;
  }

  apply = () => {};
  pageLoad = async () => {
    this.pages = await jQuery
      .get(ajaxurl + "?action=dynamic_page_list")
      .fail((err) => console.log(err.responseText));
    this.items = await jQuery
      .get(ajaxurl + "?action=dynamic_items_load")
      .then((res) => JSON.parse(res))
      .fail((err) => console.log(err.responseText));
    this.loading = false;
    this.apply?.();
  };

  isTableVisible = () =>
    Boolean(this.panels.length && typeof this.editIndex !== "number");
  isEditVisible = () => typeof this.editIndex === "number";

  getViewLink = (siteUrl) => (this.page ? `${siteUrl}/?p=${this.page}` : "#");
  getNum = (str) => parseInt(str);

  onPageChange = async () => {
    jQuery
      .post(
        ajaxurl,
        {
          action: "dynamic_page_load",
          data: this.page,
        },
        (res) => {
          this.panels = res;
          console.log(this.panels);
          this.apply?.();
        }
      )
      .fail((err) => console.log(err.responseText));
  };
  onEditPanel = (index) => {
    this.editIndex = index;
    this.editValue = Object.assign({}, this.panels[index]?.value, {
      num: parseInt(this.panels[index]?.value?.num || "0"),
    });
  };
  onEditChangeFrom = () => {
    this.editValue.items = [];
  };
  onAddItem = () => {
    const { value: id, label } =
      this.items?.[this.editValue.from]?.find(
        (i) => i.value.toString() === this.editItemSelect.toString()
      ) || {};
    if (id && label) {
      this.editValue.items = (this.editValue?.items || []).concat({
        id,
        label,
      });
      this.editItemSelect = "";
    }
  };
  onRemoveItem = (id) => {
    this.editValue.items = this.editValue.items.filter((i) => i.id !== id);
  };
  onEditCancel = () => {
    this.editIndex = false;
    this.editValue = null;
    this.editItemSelect = "";
  };
  onAddSection() {
    jQuery.post(
      ajaxurl,
      {
        action: "dynamic_update",
        data: {
          id: this.page,
          section: {},
        },
      },
      async () => {
        await this.onPageChange();
        this.apply?.();
      }
    );
  }
  onSave = () => {
    jQuery.post(
      ajaxurl,
      {
        action: "dynamic_panel_update",
        data: {
          id: this.panels[this.editIndex].id,
          value: this.editValue,
        },
      },
      async () => {
        alert("Save success");
        this.onEditCancel();
        await this.onPageChange();
        this.apply?.();
      }
    );
  };
  onRemovePanel = (id) => {
    if (confirm("Do you want to remove?")) {
      jQuery.post(
        ajaxurl,
        {
          action: "dynamic_panel_remove",
          data: { id },
        },
        async (res) => {
          await this.onPageChange();
          this.apply?.();
        }
      );
    }
  };
}
