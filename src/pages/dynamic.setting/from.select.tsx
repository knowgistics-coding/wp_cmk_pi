import React from "react";
import {
  FormControl,
  InputLabel,
  MenuItem,
  Select,
  SelectProps,
} from "@mui/material";

export const FromSelect = (props: Pick<SelectProps, "value" | "onChange">) => {
  return (
    <FormControl fullWidth>
      <InputLabel>From</InputLabel>
      <Select label="From" {...props}>
        <MenuItem value="id">ID</MenuItem>
        <MenuItem value="category">Category</MenuItem>
      </Select>
    </FormControl>
  );
};
