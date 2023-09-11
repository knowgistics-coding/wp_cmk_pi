import React, { useContext, useEffect, useState } from "react";
import { DNMSection } from "./dnm.doc";
import {
  Accordion,
  AccordionActions,
  AccordionDetails,
  AccordionSummary,
  Box,
  Button,
  Checkbox,
  Chip,
  FormControlLabel,
  Grid,
  SelectChangeEvent,
  TextField,
  Typography,
  styled,
} from "@mui/material";
import { TypeSelect } from "./type.select";
import { FromSelect } from "./from.select";
import { OrderBySelect, OrderSelect } from "./orderby.select";
import { SearchItem } from "./search.item";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faChevronDown,
  faSave,
  faTrash,
} from "@fortawesome/pro-regular-svg-icons";
import { DNMContext } from ".";

const StyledTextField = styled(TextField)({
  "& input": {
    padding: "16.5px 14px",
    lineHeight: "unset",
    minHeight: "unset",
    "&:focus": {
      borderColor: "unset",
      boxShadow: "unset",
      outline: "unset",
    },
  },
});

export const Section = ({
  doc,
  expanded,
  onchange,
}: {
  doc: DNMSection;
  expanded: boolean;
  onchange: (value: boolean) => void;
}) => {
  const { state: store, dispatch } = useContext(DNMContext);
  const [state, setState] = useState(new DNMSection());

  useEffect(() => {
    setState(doc);
  }, [doc]);

  const handleChange =
    <T extends keyof DNMSection>(key: T) =>
    ({ target: { value } }: React.ChangeEvent<HTMLInputElement>) =>
      setState((s) => s.Set(key, value as DNMSection[T]));
  const handleChangeS =
    <T extends keyof DNMSection>(key: T, clearitems?: boolean) =>
    ({ target: { value } }: SelectChangeEvent<unknown>) =>
      setState((s) => s.Set(key, value as DNMSection[T], clearitems));
  const handleUnlimited = (_: any, checked: boolean) =>
    setState((s) => s.Set("num", checked ? "-1" : "8"));
  const handleItemRemove = (id: string) => () =>
    setState((s) => s.Item().remove(id));
  const handleSearchSelect = (value: { label: string; value: number }) => {
    if (value) {
      setState((s) => s.Item().add(value));
    }
  };
  const handleSave = async () => {
    if (await state.Save()) {
      alert("Saved");
    }
  };
  const handleRemove = () => {
    const page = store.Current().post();
    if (page && confirm(`Are you sure to remove "ID: ${state.id}"?`)) {
      state
        .Remove(page.value)
        .then((value) => dispatch({ type: "section", value }));
    }
  };

  return (
    <>
      <Accordion
        expanded={expanded}
        onChange={(_, expanded) => onchange(expanded)}
      >
        <AccordionSummary expandIcon={<FontAwesomeIcon icon={faChevronDown} />}>
          ID: {doc.id}
        </AccordionSummary>
        <AccordionDetails>
          <Grid container spacing={4}>
            {/* ANCHOR - set num */}
            <Grid item xs={12}>
              {state.num !== "-1" && (
                <StyledTextField
                  fullWidth
                  label="Amount"
                  type="number"
                  value={state.num}
                  onChange={handleChange("num")}
                />
              )}
              <FormControlLabel
                checked={state.num === "-1"}
                control={<Checkbox />}
                label="Unlimited items"
                onChange={handleUnlimited}
              />
            </Grid>
            {/* ANCHOR - set type */}
            <Grid item xs={12}>
              <TypeSelect value={state.type} onChange={handleChangeS("type")} />
            </Grid>
            {/* ANCHOR - set from */}
            <Grid item xs={12}>
              <FromSelect
                value={state.from}
                onChange={handleChangeS("from", true)}
              />
            </Grid>
            <Grid item xs={12}>
              <Box>
                <SearchItem from={state.from} onChange={handleSearchSelect} />
                {state.items.length === 0 && (
                  <Typography color="textSecondary">No Items</Typography>
                )}
                {state.items.map((item) => (
                  <Chip
                    size="small"
                    key={item.id}
                    color="primary"
                    onDelete={handleItemRemove(item.id)}
                    label={`(ID: ${item.id}) ${item.label}`}
                    sx={{ mr: 0.5, mb: 0.5 }}
                  />
                ))}
              </Box>
            </Grid>
            {/* ANCHOR - set order */}
            <Grid item xs={12}>
              <OrderBySelect
                value={state.orderby}
                onChange={handleChangeS("orderby")}
              />
              <Box pt={2} />
              <OrderSelect
                value={state.order}
                onChange={handleChangeS("order")}
              />
            </Grid>
            {/* ANCHOR - set label */}
            <Grid item xs={12}>
              <StyledTextField
                fullWidth
                label="Label"
                value={state.label}
                onChange={handleChange("label")}
              />
            </Grid>
          </Grid>
        </AccordionDetails>
        <AccordionActions>
          <Button
            variant="outlined"
            color="success"
            startIcon={<FontAwesomeIcon icon={faSave} />}
            onClick={handleSave}
          >
            Update
          </Button>
          <Button
            variant="outlined"
            color="error"
            startIcon={<FontAwesomeIcon icon={faTrash} />}
            onClick={handleRemove}
          >
            Remove
          </Button>
        </AccordionActions>
      </Accordion>
    </>
  );
};
