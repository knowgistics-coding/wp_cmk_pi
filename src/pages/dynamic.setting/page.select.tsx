import React, { useContext } from "react";
import { MenuItem, Select } from "@mui/material";
import { DNMContext } from ".";

export const PageSelect = ({
  value,
  onChange,
}: {
  value: number;
  onChange: (value: number) => void;
}) => {
  const { state } = useContext(DNMContext)

  return (
    <Select
      fullWidth
      displayEmpty
      value={value}
      onChange={({ target: { value } }) => onChange(parseInt(`${value}`))}
    >
      <MenuItem value={0}>-- เลือก Page --</MenuItem>
      {state.list.page.map((doc) => (
        <MenuItem value={doc.value} key={doc.value}>
          {doc.label} (ID: {doc.value})
        </MenuItem>
      ))}
    </Select>
  );
};
