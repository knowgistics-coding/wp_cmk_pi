import React, { useEffect } from "preact/compat";
import { DNMSection } from "./dnm.section";
import { SectionHighlight } from "./highlight";

declare global {
  interface Window {
    sections?: DNMSection[];
  }
}

export const PageDynamic = () => {
  const [sections, setSections] = React.useState<DNMSection[]>([]);

  useEffect(() => {
    if (window.sections) {
      setSections(window.sections.map((data) => new DNMSection(data)));
    }
  }, []);

  return <div>{sections.map((section,index) => <React.Fragment key={index}>
    {(() => {
      switch (section.type) {
        // case "highlight":
        //   return <SectionHighlight value={section} />;
        default:
          console.log(section.type)
          return null;
      }
    })()}
  </React.Fragment>)}</div>;
};
