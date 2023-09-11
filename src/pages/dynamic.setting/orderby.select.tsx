import React from "react";
import {
  FormControl,
  InputLabel,
  MenuItem,
  Select,
  SelectProps,
} from "@mui/material";

export const OrderBySelect = (
  props: Pick<SelectProps, "value" | "onChange">
) => {
  return (
    <FormControl fullWidth>
      <InputLabel>Order By</InputLabel>
      <Select label="Order By" {...props}>
        <MenuItem value="post_title">Title</MenuItem>
        <MenuItem value="post_date">Date</MenuItem>
        <MenuItem value="post_modified">Modified</MenuItem>
      </Select>
    </FormControl>
  );
};

export const OrderSelect = (props: Pick<SelectProps, "value" | "onChange">) => {
  return (
    <FormControl fullWidth>
      <InputLabel>Order</InputLabel>
      <Select label="Order" {...props}>
        <MenuItem value="asc">ASC</MenuItem>
        <MenuItem value="desc">DESC</MenuItem>
      </Select>
    </FormControl>
  );
};
