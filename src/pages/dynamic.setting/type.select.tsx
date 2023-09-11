import React from "react";
import {
  FormControl,
  InputLabel,
  Select,
  MenuItem,
  SelectProps,
} from "@mui/material";

export const TypeSelect = (props: Pick<SelectProps, "value" | "onChange">) => {
  return (
    <FormControl fullWidth>
      <InputLabel>Type</InputLabel>
      <Select label="Type" {...props}>
        <MenuItem value="slide">Slide</MenuItem>
        <MenuItem value="card">Card</MenuItem>
        <MenuItem value="cover">Cover</MenuItem>
        <MenuItem value="text">Text</MenuItem>
        <MenuItem value="square">Square</MenuItem>
        <MenuItem value="cardslide">Card Slide</MenuItem>
        <MenuItem value="highlight">Highlight</MenuItem>
        <MenuItem value="jpaenc">สารานุกรม (Only JP-Arts)</MenuItem>
      </Select>
    </FormControl>
  );
};
