import React, { useContext, useState } from "react";
import { Autocomplete, TextField } from "@mui/material";
import { DNMContext } from ".";

export const SearchItem = ({
  from,
  onChange,
}: {
  from: string;
  onChange: (value: { label: string; value: number }) => void;
}) => {
  const { state } = useContext(DNMContext);
  const [value, setValue] = useState<any>(null);

  return (
    <Autocomplete
      disablePortal
      options={state.list?.[from] ?? []}
      renderInput={(params) => <TextField {...params} />}
      value={value}
      onChange={(_, value) => {
        onChange(value as any);
        setTimeout(() => setValue(null), 100);
      }}
      sx={{ mb: 2 }}
    />
  );
};
