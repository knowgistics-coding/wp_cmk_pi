import React, { useEffect, useState } from "preact/compat";
import { DNMSection } from "./dnm.section";
import { Post } from "./post";

export type SectionHighlightProps = {
  value: DNMSection;
};
export const SectionHighlight = (props: SectionHighlightProps) => {
  const [posts, setPosts] = useState<Post[]>([]);

  useEffect(() => {
    props.value.query().then((posts) => setPosts(posts));
  }, [props.value]);

  return (
    <div className="container pb-5 rx-highlight-container">
      {posts.map((post) => (
        <div className="rx-highlight" key={post.id}>
          <img src={post.get().thumbnail()} alt={post.title.rendered} />
          <div>{post.title.rendered}</div>
        </div>
      ))}
    </div>
  );
};
