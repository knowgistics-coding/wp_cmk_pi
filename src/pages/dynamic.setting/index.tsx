import { render } from "preact";
import React, { createContext, useEffect, useReducer } from "react";
import { PageSelect } from "./page.select";
import { DNMState, DNMStateAction } from "./dnm.state";
import { DNMDoc, DNMSection } from "./dnm.doc";
import { Section } from "./section";
import { Box, Button, Container, Link, Stack, Typography } from "@mui/material";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faPlus } from "@fortawesome/pro-regular-svg-icons";

export class DynamicSetting {
  selector: string = "";

  constructor(selector: string) {
    this.selector = selector;
  }

  render() {
    const root = document.querySelector(this.selector);
    if (root) {
      render(<DynamicSettingComponent />, root);
    }
  }
}

export const DNMContext = createContext<{
  state: DNMState;
  dispatch: React.Dispatch<DNMStateAction>;
}>({
  state: new DNMState(),
  dispatch: () => {},
});

const DynamicSettingComponent = () => {
  const [state, dispatch] = useReducer(DNMState.reducer, new DNMState());

  useEffect(() => {
    DNMDoc.loadItems().then((list) => dispatch({ type: "list", value: list }));
  }, []);

  useEffect(() => {
    if (state.page > 0) {
      DNMDoc.loadPage(state.page).then((sections) =>
        dispatch({ type: "section", value: sections })
      );
    }
  }, [state.page]);

  const handleAdd = () => {
    const page = state.Current().post();
    if (page) {
      DNMSection.add(`${page.value}`).then((value) =>
        dispatch({ type: "section", value })
      );
    }
  };

  return (
    <DNMContext.Provider value={{ state, dispatch }}>
      <Container maxWidth="md" sx={{ py: 6 }}>
        <PageSelect
          value={state.page}
          onChange={(value) => dispatch({ type: "page", value })}
        />
        {state.page > 0 && (
          <Stack spacing={4} sx={{ pt: 4 }}>
            <Box>
              <Link
                variant="h6"
                fontWeight="bold"
                href={state.Current().link()}
                target="_blank"
              >
                {state.Current().label()}
              </Link>
            </Box>
            <Box>
              {state.sections.length === 0 && (
                <Typography color="textSecondary">No Sections</Typography>
              )}
              {state.sections.map((section, index) => (
                <Section
                  doc={section}
                  expanded={state.expanded === index}
                  onchange={(value) =>
                    dispatch({ type: "expanded", index, value })
                  }
                />
              ))}
            </Box>
            <Box>
              <Button
                variant="outlined"
                startIcon={<FontAwesomeIcon icon={faPlus} />}
                onClick={handleAdd}
              >
                Add
              </Button>
            </Box>
          </Stack>
        )}
      </Container>
    </DNMContext.Provider>
  );
};
