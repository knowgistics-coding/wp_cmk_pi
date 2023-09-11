// To parse this data:
//
//   import { Convert } from "./file";
//
//   const post = Convert.toPost(json);
//
// These functions will throw an error if the JSON doesn't
// match the expected interface, even if the JSON is valid.

export class Post {
    id:              number;
    date:            Date;
    date_gmt:        Date;
    guid:            GUID;
    modified:        Date;
    modified_gmt:    Date;
    slug:            string;
    status:          string;
    type:            string;
    link:            string;
    title:           GUID;
    content:         Content;
    excerpt:         Content;
    author:          number;
    featured_media:  number;
    comment_status:  string;
    ping_status:     string;
    sticky:          boolean;
    template:        string;
    format:          string;
    meta:            any[];
    categories:      number[];
    tags:            any[];
    yoast_head:      string;
    yoast_head_json: PostYoastHeadJSON;
    _links:          PostLinks;
    _embedded:       Embedded;

    constructor(data?: Partial<Post>) {
        Object.assign(this, data);
    }

    get(){
      return {
        thumbnail: () => this._embedded["wp:featuredmedia"][0].source_url,
      }
    }
}

export interface Embedded {
    author:             EmbeddedAuthor[];
    "wp:featuredmedia": WpFeaturedmedia[];
    "wp:term":          Array<EmbeddedWpTerm[]>;
}

export interface EmbeddedAuthor {
    id:              number;
    name:            AuthorEnum;
    url:             string;
    description:     string;
    link:            string;
    slug:            string;
    avatar_urls:     { [key: string]: string };
    yoast_head:      string;
    yoast_head_json: AuthorYoastHeadJSON;
    _links:          AuthorLinks;
}

export interface AuthorLinks {
    self:       About[];
    collection: About[];
}

export interface About {
    href: string;
}

export enum AuthorEnum {
    Daruma = "Daruma",
    DarumaAuthorAtJPArts = "Daruma, Author at JP-Arts",
    JPArts = "JP-Arts",
}

export interface AuthorYoastHeadJSON {
    title:        AuthorEnum;
    robots:       Robots;
    canonical:    string;
    og_locale:    string;
    og_type:      string;
    og_title:     AuthorEnum;
    og_url:       string;
    og_site_name: AuthorEnum;
    og_image:     PurpleOgImage[];
    twitter_card: string;
    schema:       PurpleSchema;
}

export interface PurpleOgImage {
    url: string;
}

export interface Robots {
    index:               Index;
    follow:              Follow;
    "max-snippet":       MaxSnippet;
    "max-image-preview": MaxImagePreview;
    "max-video-preview": MaxVideoPreview;
}

export enum Follow {
    Follow = "follow",
}

export enum Index {
    Index = "index",
}

export enum MaxImagePreview {
    MaxImagePreviewLarge = "max-image-preview:large",
}

export enum MaxSnippet {
    MaxSnippet1 = "max-snippet:-1",
}

export enum MaxVideoPreview {
    MaxVideoPreview1 = "max-video-preview:-1",
}

export interface PurpleSchema {
    "@context": string;
    "@graph":   PurpleGraph[];
}

export interface PurpleGraph {
    "@type":           string;
    "@id":             string;
    url?:              string;
    name?:             AuthorEnum;
    isPartOf?:         Breadcrumb;
    breadcrumb?:       Breadcrumb;
    inLanguage?:       InLanguage;
    potentialAction?:  PurplePotentialAction[];
    itemListElement?:  ItemListElement[];
    description?:      string;
    publisher?:        Breadcrumb;
    logo?:             Image;
    image?:            Image;
    sameAs?:           string[];
    mainEntityOfPage?: Breadcrumb;
}

export interface Breadcrumb {
    "@id": string;
}

export interface Image {
    "@id":       string;
    "@type"?:    ImageType;
    inLanguage?: InLanguage;
    url?:        string;
    contentUrl?: string;
    caption?:    AuthorEnum;
    width?:      number;
    height?:     number;
}

export enum ImageType {
    ImageObject = "ImageObject",
}

export enum InLanguage {
    EnUS = "en-US",
}

export interface ItemListElement {
    "@type":  ItemListElementType;
    position: number;
    name:     string;
    item?:    string;
}

export enum ItemListElementType {
    ListItem = "ListItem",
}

export interface PurplePotentialAction {
    "@type":        PotentialActionType;
    target:         string[] | TargetClass;
    "query-input"?: QueryInput;
}

export enum PotentialActionType {
    ReadAction = "ReadAction",
    SearchAction = "SearchAction",
}

export enum QueryInput {
    RequiredNameSearchTermString = "required name=search_term_string",
}

export interface TargetClass {
    "@type":     TargetType;
    urlTemplate: URLTemplate;
}

export enum TargetType {
    EntryPoint = "EntryPoint",
}

export enum URLTemplate {
    HTTPSJpArtsInfoSSearchTermString = "https://jp-arts.info/?s={search_term_string}",
}

export interface WpFeaturedmedia {
    id:            number;
    date:          Date;
    slug:          string;
    type:          string;
    link:          string;
    title:         GUID;
    author:        number;
    caption:       GUID;
    alt_text:      string;
    media_type:    string;
    mime_type:     Type;
    media_details: MediaDetails;
    source_url:    string;
    _links:        WpFeaturedmediaLinks;
}

export interface WpFeaturedmediaLinks {
    self:       About[];
    collection: About[];
    about:      About[];
    replies:    ReplyElement[];
}

export interface ReplyElement {
    embeddable: boolean;
    href:       string;
}

export interface GUID {
    rendered: string;
}

export interface MediaDetails {
    width:      number;
    height:     number;
    file:       string;
    sizes:      Sizes;
    image_meta: ImageMeta;
}

export interface ImageMeta {
    aperture:          string;
    credit:            string;
    camera:            string;
    caption:           string;
    created_timestamp: string;
    copyright:         string;
    focal_length:      string;
    iso:               string;
    shutter_speed:     string;
    title:             string;
    orientation:       string;
    keywords:          any[];
}

export interface Sizes {
    thumbnail:    Full;
    medium:       Full;
    medium_large: Full;
    large:        Full;
    full:         Full;
}

export interface Full {
    file:       string;
    width:      number;
    height:     number;
    mime_type:  Type;
    source_url: string;
}

export enum Type {
    ImageJPEG = "image/jpeg",
}

export interface EmbeddedWpTerm {
    id:              number;
    link:            string;
    name:            string;
    slug:            string;
    taxonomy:        Taxonomy;
    yoast_head:      string;
    yoast_head_json: WpTermYoastHeadJSON;
    _links:          WpTermLinks;
}

export interface WpTermLinks {
    self:           About[];
    collection:     About[];
    about:          About[];
    "wp:post_type": About[];
    curies:         Cury[];
}

export interface Cury {
    name:      Name;
    href:      Href;
    templated: boolean;
}

export enum Href {
    HTTPSAPIWOrgRel = "https://api.w.org/{rel}",
}

export enum Name {
    Wp = "wp",
}

export enum Taxonomy {
    Category = "category",
    PostTag = "post_tag",
}

export interface WpTermYoastHeadJSON {
    title:        OgTitle;
    robots:       Robots;
    canonical:    string;
    og_locale:    string;
    og_type:      string;
    og_title:     OgTitle;
    og_url:       string;
    og_site_name: AuthorEnum;
    twitter_card: string;
    schema:       FluffySchema;
}

export enum OgTitle {
    HighlightArchivesJPArts = "Highlight Archives - JP-Arts",
    JPArts = "JP-Arts",
}

export interface FluffySchema {
    "@context": string;
    "@graph":   FluffyGraph[];
}

export interface FluffyGraph {
    "@type":          GraphType;
    "@id":            string;
    url?:             string;
    name?:            OgTitle;
    isPartOf?:        Breadcrumb;
    breadcrumb?:      Breadcrumb;
    inLanguage?:      InLanguage;
    itemListElement?: ItemListElement[];
    description?:     string;
    publisher?:       Breadcrumb;
    potentialAction?: FluffyPotentialAction[];
    logo?:            Image;
    image?:           Breadcrumb;
    sameAs?:          string[];
}

export enum GraphType {
    BreadcrumbList = "BreadcrumbList",
    CollectionPage = "CollectionPage",
    Organization = "Organization",
    WebSite = "WebSite",
}

export interface FluffyPotentialAction {
    "@type":       PotentialActionType;
    target:        TargetClass;
    "query-input": QueryInput;
}

export interface PostLinks {
    self:                  About[];
    collection:            About[];
    about:                 About[];
    author:                ReplyElement[];
    replies:               ReplyElement[];
    "version-history":     VersionHistory[];
    "predecessor-version": PredecessorVersion[];
    "wp:featuredmedia":    ReplyElement[];
    "wp:attachment":       About[];
    "wp:term":             LinksWpTerm[];
    curies:                Cury[];
}

export interface PredecessorVersion {
    id:   number;
    href: string;
}

export interface VersionHistory {
    count: number;
    href:  string;
}

export interface LinksWpTerm {
    taxonomy:   Taxonomy;
    embeddable: boolean;
    href:       string;
}

export interface Content {
    rendered:  string;
    protected: boolean;
}

export interface PostYoastHeadJSON {
    title:                  string;
    robots:                 Robots;
    canonical:              string;
    og_locale:              string;
    og_type:                string;
    og_title:               string;
    og_description:         string;
    og_url:                 string;
    og_site_name:           AuthorEnum;
    article_publisher:      string;
    article_published_time: Date;
    article_modified_time:  Date;
    og_image:               FluffyOgImage[];
    author:                 AuthorEnum;
    twitter_card:           string;
    twitter_misc:           TwitterMisc;
    schema:                 TentacledSchema;
}

export interface FluffyOgImage {
    width:  number;
    height: number;
    url:    string;
    type:   Type;
}

export interface TentacledSchema {
    "@context": string;
    "@graph":   TentacledGraph[];
}

export interface TentacledGraph {
    "@type":           string;
    "@id":             string;
    isPartOf?:         Breadcrumb;
    author?:           GraphAuthorClass;
    headline?:         string;
    datePublished?:    Date;
    dateModified?:     Date;
    mainEntityOfPage?: Breadcrumb;
    wordCount?:        number;
    publisher?:        Breadcrumb;
    articleSection?:   string[];
    inLanguage?:       InLanguage;
    url?:              string;
    name?:             string;
    breadcrumb?:       Breadcrumb;
    potentialAction?:  PurplePotentialAction[];
    itemListElement?:  ItemListElement[];
    description?:      string;
    logo?:             Image;
    image?:            Image;
    sameAs?:           string[];
}

export interface GraphAuthorClass {
    name:  AuthorEnum;
    "@id": string;
}

export interface TwitterMisc {
    "Written by": AuthorEnum;
}

// Converts JSON strings to/from your types
// and asserts the results of JSON.parse at runtime
export class Convert {
    public static toPost(json: string): Post[] {
        return cast(JSON.parse(json), a(r("Post")));
    }

    public static postToJson(value: Post[]): string {
        return JSON.stringify(uncast(value, a(r("Post"))), null, 2);
    }
}

function invalidValue(typ: any, val: any, key: any = ''): never {
    if (key) {
        throw Error(`Invalid value for key "${key}". Expected type ${JSON.stringify(typ)} but got ${JSON.stringify(val)}`);
    }
    throw Error(`Invalid value ${JSON.stringify(val)} for type ${JSON.stringify(typ)}`, );
}

function jsonToJSProps(typ: any): any {
    if (typ.jsonToJS === undefined) {
        const map: any = {};
        typ.props.forEach((p: any) => map[p.json] = { key: p.js, typ: p.typ });
        typ.jsonToJS = map;
    }
    return typ.jsonToJS;
}

function jsToJSONProps(typ: any): any {
    if (typ.jsToJSON === undefined) {
        const map: any = {};
        typ.props.forEach((p: any) => map[p.js] = { key: p.json, typ: p.typ });
        typ.jsToJSON = map;
    }
    return typ.jsToJSON;
}

function transform(val: any, typ: any, getProps: any, key: any = ''): any {
    function transformPrimitive(typ: string, val: any): any {
        if (typeof typ === typeof val) return val;
        return invalidValue(typ, val, key);
    }

    function transformUnion(typs: any[], val: any): any {
        // val must validate against one typ in typs
        const l = typs.length;
        for (let i = 0; i < l; i++) {
            const typ = typs[i];
            try {
                return transform(val, typ, getProps);
            } catch (_) {}
        }
        return invalidValue(typs, val);
    }

    function transformEnum(cases: string[], val: any): any {
        if (cases.indexOf(val) !== -1) return val;
        return invalidValue(cases, val);
    }

    function transformArray(typ: any, val: any): any {
        // val must be an array with no invalid elements
        if (!Array.isArray(val)) return invalidValue("array", val);
        return val.map(el => transform(el, typ, getProps));
    }

    function transformDate(val: any): any {
        if (val === null) {
            return null;
        }
        const d = new Date(val);
        if (isNaN(d.valueOf())) {
            return invalidValue("Date", val);
        }
        return d;
    }

    function transformObject(props: { [k: string]: any }, additional: any, val: any): any {
        if (val === null || typeof val !== "object" || Array.isArray(val)) {
            return invalidValue("object", val);
        }
        const result: any = {};
        Object.getOwnPropertyNames(props).forEach(key => {
            const prop = props[key];
            const v = Object.prototype.hasOwnProperty.call(val, key) ? val[key] : undefined;
            result[prop.key] = transform(v, prop.typ, getProps, prop.key);
        });
        Object.getOwnPropertyNames(val).forEach(key => {
            if (!Object.prototype.hasOwnProperty.call(props, key)) {
                result[key] = transform(val[key], additional, getProps, key);
            }
        });
        return result;
    }

    if (typ === "any") return val;
    if (typ === null) {
        if (val === null) return val;
        return invalidValue(typ, val);
    }
    if (typ === false) return invalidValue(typ, val);
    while (typeof typ === "object" && typ.ref !== undefined) {
        typ = typeMap[typ.ref];
    }
    if (Array.isArray(typ)) return transformEnum(typ, val);
    if (typeof typ === "object") {
        return typ.hasOwnProperty("unionMembers") ? transformUnion(typ.unionMembers, val)
            : typ.hasOwnProperty("arrayItems")    ? transformArray(typ.arrayItems, val)
            : typ.hasOwnProperty("props")         ? transformObject(getProps(typ), typ.additional, val)
            : invalidValue(typ, val);
    }
    // Numbers can be parsed by Date but shouldn't be.
    if (typ === Date && typeof val !== "number") return transformDate(val);
    return transformPrimitive(typ, val);
}

function cast<T>(val: any, typ: any): T {
    return transform(val, typ, jsonToJSProps);
}

function uncast<T>(val: T, typ: any): any {
    return transform(val, typ, jsToJSONProps);
}

function a(typ: any) {
    return { arrayItems: typ };
}

function u(...typs: any[]) {
    return { unionMembers: typs };
}

function o(props: any[], additional: any) {
    return { props, additional };
}

function m(additional: any) {
    return { props: [], additional };
}

function r(name: string) {
    return { ref: name };
}

const typeMap: any = {
    "Post": o([
        { json: "id", js: "id", typ: 0 },
        { json: "date", js: "date", typ: Date },
        { json: "date_gmt", js: "date_gmt", typ: Date },
        { json: "guid", js: "guid", typ: r("GUID") },
        { json: "modified", js: "modified", typ: Date },
        { json: "modified_gmt", js: "modified_gmt", typ: Date },
        { json: "slug", js: "slug", typ: "" },
        { json: "status", js: "status", typ: "" },
        { json: "type", js: "type", typ: "" },
        { json: "link", js: "link", typ: "" },
        { json: "title", js: "title", typ: r("GUID") },
        { json: "content", js: "content", typ: r("Content") },
        { json: "excerpt", js: "excerpt", typ: r("Content") },
        { json: "author", js: "author", typ: 0 },
        { json: "featured_media", js: "featured_media", typ: 0 },
        { json: "comment_status", js: "comment_status", typ: "" },
        { json: "ping_status", js: "ping_status", typ: "" },
        { json: "sticky", js: "sticky", typ: true },
        { json: "template", js: "template", typ: "" },
        { json: "format", js: "format", typ: "" },
        { json: "meta", js: "meta", typ: a("any") },
        { json: "categories", js: "categories", typ: a(0) },
        { json: "tags", js: "tags", typ: a("any") },
        { json: "yoast_head", js: "yoast_head", typ: "" },
        { json: "yoast_head_json", js: "yoast_head_json", typ: r("PostYoastHeadJSON") },
        { json: "_links", js: "_links", typ: r("PostLinks") },
        { json: "_embedded", js: "_embedded", typ: r("Embedded") },
    ], false),
    "Embedded": o([
        { json: "author", js: "author", typ: a(r("EmbeddedAuthor")) },
        { json: "wp:featuredmedia", js: "wp:featuredmedia", typ: a(r("WpFeaturedmedia")) },
        { json: "wp:term", js: "wp:term", typ: a(a(r("EmbeddedWpTerm"))) },
    ], false),
    "EmbeddedAuthor": o([
        { json: "id", js: "id", typ: 0 },
        { json: "name", js: "name", typ: r("AuthorEnum") },
        { json: "url", js: "url", typ: "" },
        { json: "description", js: "description", typ: "" },
        { json: "link", js: "link", typ: "" },
        { json: "slug", js: "slug", typ: "" },
        { json: "avatar_urls", js: "avatar_urls", typ: m("") },
        { json: "yoast_head", js: "yoast_head", typ: "" },
        { json: "yoast_head_json", js: "yoast_head_json", typ: r("AuthorYoastHeadJSON") },
        { json: "_links", js: "_links", typ: r("AuthorLinks") },
    ], false),
    "AuthorLinks": o([
        { json: "self", js: "self", typ: a(r("About")) },
        { json: "collection", js: "collection", typ: a(r("About")) },
    ], false),
    "About": o([
        { json: "href", js: "href", typ: "" },
    ], false),
    "AuthorYoastHeadJSON": o([
        { json: "title", js: "title", typ: r("AuthorEnum") },
        { json: "robots", js: "robots", typ: r("Robots") },
        { json: "canonical", js: "canonical", typ: "" },
        { json: "og_locale", js: "og_locale", typ: "" },
        { json: "og_type", js: "og_type", typ: "" },
        { json: "og_title", js: "og_title", typ: r("AuthorEnum") },
        { json: "og_url", js: "og_url", typ: "" },
        { json: "og_site_name", js: "og_site_name", typ: r("AuthorEnum") },
        { json: "og_image", js: "og_image", typ: a(r("PurpleOgImage")) },
        { json: "twitter_card", js: "twitter_card", typ: "" },
        { json: "schema", js: "schema", typ: r("PurpleSchema") },
    ], false),
    "PurpleOgImage": o([
        { json: "url", js: "url", typ: "" },
    ], false),
    "Robots": o([
        { json: "index", js: "index", typ: r("Index") },
        { json: "follow", js: "follow", typ: r("Follow") },
        { json: "max-snippet", js: "max-snippet", typ: r("MaxSnippet") },
        { json: "max-image-preview", js: "max-image-preview", typ: r("MaxImagePreview") },
        { json: "max-video-preview", js: "max-video-preview", typ: r("MaxVideoPreview") },
    ], false),
    "PurpleSchema": o([
        { json: "@context", js: "@context", typ: "" },
        { json: "@graph", js: "@graph", typ: a(r("PurpleGraph")) },
    ], false),
    "PurpleGraph": o([
        { json: "@type", js: "@type", typ: "" },
        { json: "@id", js: "@id", typ: "" },
        { json: "url", js: "url", typ: u(undefined, "") },
        { json: "name", js: "name", typ: u(undefined, r("AuthorEnum")) },
        { json: "isPartOf", js: "isPartOf", typ: u(undefined, r("Breadcrumb")) },
        { json: "breadcrumb", js: "breadcrumb", typ: u(undefined, r("Breadcrumb")) },
        { json: "inLanguage", js: "inLanguage", typ: u(undefined, r("InLanguage")) },
        { json: "potentialAction", js: "potentialAction", typ: u(undefined, a(r("PurplePotentialAction"))) },
        { json: "itemListElement", js: "itemListElement", typ: u(undefined, a(r("ItemListElement"))) },
        { json: "description", js: "description", typ: u(undefined, "") },
        { json: "publisher", js: "publisher", typ: u(undefined, r("Breadcrumb")) },
        { json: "logo", js: "logo", typ: u(undefined, r("Image")) },
        { json: "image", js: "image", typ: u(undefined, r("Image")) },
        { json: "sameAs", js: "sameAs", typ: u(undefined, a("")) },
        { json: "mainEntityOfPage", js: "mainEntityOfPage", typ: u(undefined, r("Breadcrumb")) },
    ], false),
    "Breadcrumb": o([
        { json: "@id", js: "@id", typ: "" },
    ], false),
    "Image": o([
        { json: "@id", js: "@id", typ: "" },
        { json: "@type", js: "@type", typ: u(undefined, r("ImageType")) },
        { json: "inLanguage", js: "inLanguage", typ: u(undefined, r("InLanguage")) },
        { json: "url", js: "url", typ: u(undefined, "") },
        { json: "contentUrl", js: "contentUrl", typ: u(undefined, "") },
        { json: "caption", js: "caption", typ: u(undefined, r("AuthorEnum")) },
        { json: "width", js: "width", typ: u(undefined, 0) },
        { json: "height", js: "height", typ: u(undefined, 0) },
    ], false),
    "ItemListElement": o([
        { json: "@type", js: "@type", typ: r("ItemListElementType") },
        { json: "position", js: "position", typ: 0 },
        { json: "name", js: "name", typ: "" },
        { json: "item", js: "item", typ: u(undefined, "") },
    ], false),
    "PurplePotentialAction": o([
        { json: "@type", js: "@type", typ: r("PotentialActionType") },
        { json: "target", js: "target", typ: u(a(""), r("TargetClass")) },
        { json: "query-input", js: "query-input", typ: u(undefined, r("QueryInput")) },
    ], false),
    "TargetClass": o([
        { json: "@type", js: "@type", typ: r("TargetType") },
        { json: "urlTemplate", js: "urlTemplate", typ: r("URLTemplate") },
    ], false),
    "WpFeaturedmedia": o([
        { json: "id", js: "id", typ: 0 },
        { json: "date", js: "date", typ: Date },
        { json: "slug", js: "slug", typ: "" },
        { json: "type", js: "type", typ: "" },
        { json: "link", js: "link", typ: "" },
        { json: "title", js: "title", typ: r("GUID") },
        { json: "author", js: "author", typ: 0 },
        { json: "caption", js: "caption", typ: r("GUID") },
        { json: "alt_text", js: "alt_text", typ: "" },
        { json: "media_type", js: "media_type", typ: "" },
        { json: "mime_type", js: "mime_type", typ: r("Type") },
        { json: "media_details", js: "media_details", typ: r("MediaDetails") },
        { json: "source_url", js: "source_url", typ: "" },
        { json: "_links", js: "_links", typ: r("WpFeaturedmediaLinks") },
    ], false),
    "WpFeaturedmediaLinks": o([
        { json: "self", js: "self", typ: a(r("About")) },
        { json: "collection", js: "collection", typ: a(r("About")) },
        { json: "about", js: "about", typ: a(r("About")) },
        { json: "replies", js: "replies", typ: a(r("ReplyElement")) },
    ], false),
    "ReplyElement": o([
        { json: "embeddable", js: "embeddable", typ: true },
        { json: "href", js: "href", typ: "" },
    ], false),
    "GUID": o([
        { json: "rendered", js: "rendered", typ: "" },
    ], false),
    "MediaDetails": o([
        { json: "width", js: "width", typ: 0 },
        { json: "height", js: "height", typ: 0 },
        { json: "file", js: "file", typ: "" },
        { json: "sizes", js: "sizes", typ: r("Sizes") },
        { json: "image_meta", js: "image_meta", typ: r("ImageMeta") },
    ], false),
    "ImageMeta": o([
        { json: "aperture", js: "aperture", typ: "" },
        { json: "credit", js: "credit", typ: "" },
        { json: "camera", js: "camera", typ: "" },
        { json: "caption", js: "caption", typ: "" },
        { json: "created_timestamp", js: "created_timestamp", typ: "" },
        { json: "copyright", js: "copyright", typ: "" },
        { json: "focal_length", js: "focal_length", typ: "" },
        { json: "iso", js: "iso", typ: "" },
        { json: "shutter_speed", js: "shutter_speed", typ: "" },
        { json: "title", js: "title", typ: "" },
        { json: "orientation", js: "orientation", typ: "" },
        { json: "keywords", js: "keywords", typ: a("any") },
    ], false),
    "Sizes": o([
        { json: "thumbnail", js: "thumbnail", typ: r("Full") },
        { json: "medium", js: "medium", typ: r("Full") },
        { json: "medium_large", js: "medium_large", typ: r("Full") },
        { json: "large", js: "large", typ: r("Full") },
        { json: "full", js: "full", typ: r("Full") },
    ], false),
    "Full": o([
        { json: "file", js: "file", typ: "" },
        { json: "width", js: "width", typ: 0 },
        { json: "height", js: "height", typ: 0 },
        { json: "mime_type", js: "mime_type", typ: r("Type") },
        { json: "source_url", js: "source_url", typ: "" },
    ], false),
    "EmbeddedWpTerm": o([
        { json: "id", js: "id", typ: 0 },
        { json: "link", js: "link", typ: "" },
        { json: "name", js: "name", typ: "" },
        { json: "slug", js: "slug", typ: "" },
        { json: "taxonomy", js: "taxonomy", typ: r("Taxonomy") },
        { json: "yoast_head", js: "yoast_head", typ: "" },
        { json: "yoast_head_json", js: "yoast_head_json", typ: r("WpTermYoastHeadJSON") },
        { json: "_links", js: "_links", typ: r("WpTermLinks") },
    ], false),
    "WpTermLinks": o([
        { json: "self", js: "self", typ: a(r("About")) },
        { json: "collection", js: "collection", typ: a(r("About")) },
        { json: "about", js: "about", typ: a(r("About")) },
        { json: "wp:post_type", js: "wp:post_type", typ: a(r("About")) },
        { json: "curies", js: "curies", typ: a(r("Cury")) },
    ], false),
    "Cury": o([
        { json: "name", js: "name", typ: r("Name") },
        { json: "href", js: "href", typ: r("Href") },
        { json: "templated", js: "templated", typ: true },
    ], false),
    "WpTermYoastHeadJSON": o([
        { json: "title", js: "title", typ: r("OgTitle") },
        { json: "robots", js: "robots", typ: r("Robots") },
        { json: "canonical", js: "canonical", typ: "" },
        { json: "og_locale", js: "og_locale", typ: "" },
        { json: "og_type", js: "og_type", typ: "" },
        { json: "og_title", js: "og_title", typ: r("OgTitle") },
        { json: "og_url", js: "og_url", typ: "" },
        { json: "og_site_name", js: "og_site_name", typ: r("AuthorEnum") },
        { json: "twitter_card", js: "twitter_card", typ: "" },
        { json: "schema", js: "schema", typ: r("FluffySchema") },
    ], false),
    "FluffySchema": o([
        { json: "@context", js: "@context", typ: "" },
        { json: "@graph", js: "@graph", typ: a(r("FluffyGraph")) },
    ], false),
    "FluffyGraph": o([
        { json: "@type", js: "@type", typ: r("GraphType") },
        { json: "@id", js: "@id", typ: "" },
        { json: "url", js: "url", typ: u(undefined, "") },
        { json: "name", js: "name", typ: u(undefined, r("OgTitle")) },
        { json: "isPartOf", js: "isPartOf", typ: u(undefined, r("Breadcrumb")) },
        { json: "breadcrumb", js: "breadcrumb", typ: u(undefined, r("Breadcrumb")) },
        { json: "inLanguage", js: "inLanguage", typ: u(undefined, r("InLanguage")) },
        { json: "itemListElement", js: "itemListElement", typ: u(undefined, a(r("ItemListElement"))) },
        { json: "description", js: "description", typ: u(undefined, "") },
        { json: "publisher", js: "publisher", typ: u(undefined, r("Breadcrumb")) },
        { json: "potentialAction", js: "potentialAction", typ: u(undefined, a(r("FluffyPotentialAction"))) },
        { json: "logo", js: "logo", typ: u(undefined, r("Image")) },
        { json: "image", js: "image", typ: u(undefined, r("Breadcrumb")) },
        { json: "sameAs", js: "sameAs", typ: u(undefined, a("")) },
    ], false),
    "FluffyPotentialAction": o([
        { json: "@type", js: "@type", typ: r("PotentialActionType") },
        { json: "target", js: "target", typ: r("TargetClass") },
        { json: "query-input", js: "query-input", typ: r("QueryInput") },
    ], false),
    "PostLinks": o([
        { json: "self", js: "self", typ: a(r("About")) },
        { json: "collection", js: "collection", typ: a(r("About")) },
        { json: "about", js: "about", typ: a(r("About")) },
        { json: "author", js: "author", typ: a(r("ReplyElement")) },
        { json: "replies", js: "replies", typ: a(r("ReplyElement")) },
        { json: "version-history", js: "version-history", typ: a(r("VersionHistory")) },
        { json: "predecessor-version", js: "predecessor-version", typ: a(r("PredecessorVersion")) },
        { json: "wp:featuredmedia", js: "wp:featuredmedia", typ: a(r("ReplyElement")) },
        { json: "wp:attachment", js: "wp:attachment", typ: a(r("About")) },
        { json: "wp:term", js: "wp:term", typ: a(r("LinksWpTerm")) },
        { json: "curies", js: "curies", typ: a(r("Cury")) },
    ], false),
    "PredecessorVersion": o([
        { json: "id", js: "id", typ: 0 },
        { json: "href", js: "href", typ: "" },
    ], false),
    "VersionHistory": o([
        { json: "count", js: "count", typ: 0 },
        { json: "href", js: "href", typ: "" },
    ], false),
    "LinksWpTerm": o([
        { json: "taxonomy", js: "taxonomy", typ: r("Taxonomy") },
        { json: "embeddable", js: "embeddable", typ: true },
        { json: "href", js: "href", typ: "" },
    ], false),
    "Content": o([
        { json: "rendered", js: "rendered", typ: "" },
        { json: "protected", js: "protected", typ: true },
    ], false),
    "PostYoastHeadJSON": o([
        { json: "title", js: "title", typ: "" },
        { json: "robots", js: "robots", typ: r("Robots") },
        { json: "canonical", js: "canonical", typ: "" },
        { json: "og_locale", js: "og_locale", typ: "" },
        { json: "og_type", js: "og_type", typ: "" },
        { json: "og_title", js: "og_title", typ: "" },
        { json: "og_description", js: "og_description", typ: "" },
        { json: "og_url", js: "og_url", typ: "" },
        { json: "og_site_name", js: "og_site_name", typ: r("AuthorEnum") },
        { json: "article_publisher", js: "article_publisher", typ: "" },
        { json: "article_published_time", js: "article_published_time", typ: Date },
        { json: "article_modified_time", js: "article_modified_time", typ: Date },
        { json: "og_image", js: "og_image", typ: a(r("FluffyOgImage")) },
        { json: "author", js: "author", typ: r("AuthorEnum") },
        { json: "twitter_card", js: "twitter_card", typ: "" },
        { json: "twitter_misc", js: "twitter_misc", typ: r("TwitterMisc") },
        { json: "schema", js: "schema", typ: r("TentacledSchema") },
    ], false),
    "FluffyOgImage": o([
        { json: "width", js: "width", typ: 0 },
        { json: "height", js: "height", typ: 0 },
        { json: "url", js: "url", typ: "" },
        { json: "type", js: "type", typ: r("Type") },
    ], false),
    "TentacledSchema": o([
        { json: "@context", js: "@context", typ: "" },
        { json: "@graph", js: "@graph", typ: a(r("TentacledGraph")) },
    ], false),
    "TentacledGraph": o([
        { json: "@type", js: "@type", typ: "" },
        { json: "@id", js: "@id", typ: "" },
        { json: "isPartOf", js: "isPartOf", typ: u(undefined, r("Breadcrumb")) },
        { json: "author", js: "author", typ: u(undefined, r("GraphAuthorClass")) },
        { json: "headline", js: "headline", typ: u(undefined, "") },
        { json: "datePublished", js: "datePublished", typ: u(undefined, Date) },
        { json: "dateModified", js: "dateModified", typ: u(undefined, Date) },
        { json: "mainEntityOfPage", js: "mainEntityOfPage", typ: u(undefined, r("Breadcrumb")) },
        { json: "wordCount", js: "wordCount", typ: u(undefined, 0) },
        { json: "publisher", js: "publisher", typ: u(undefined, r("Breadcrumb")) },
        { json: "articleSection", js: "articleSection", typ: u(undefined, a("")) },
        { json: "inLanguage", js: "inLanguage", typ: u(undefined, r("InLanguage")) },
        { json: "url", js: "url", typ: u(undefined, "") },
        { json: "name", js: "name", typ: u(undefined, "") },
        { json: "breadcrumb", js: "breadcrumb", typ: u(undefined, r("Breadcrumb")) },
        { json: "potentialAction", js: "potentialAction", typ: u(undefined, a(r("PurplePotentialAction"))) },
        { json: "itemListElement", js: "itemListElement", typ: u(undefined, a(r("ItemListElement"))) },
        { json: "description", js: "description", typ: u(undefined, "") },
        { json: "logo", js: "logo", typ: u(undefined, r("Image")) },
        { json: "image", js: "image", typ: u(undefined, r("Image")) },
        { json: "sameAs", js: "sameAs", typ: u(undefined, a("")) },
    ], false),
    "GraphAuthorClass": o([
        { json: "name", js: "name", typ: r("AuthorEnum") },
        { json: "@id", js: "@id", typ: "" },
    ], false),
    "TwitterMisc": o([
        { json: "Written by", js: "Written by", typ: r("AuthorEnum") },
    ], false),
    "AuthorEnum": [
        "Daruma",
        "Daruma, Author at JP-Arts",
        "JP-Arts",
    ],
    "Follow": [
        "follow",
    ],
    "Index": [
        "index",
    ],
    "MaxImagePreview": [
        "max-image-preview:large",
    ],
    "MaxSnippet": [
        "max-snippet:-1",
    ],
    "MaxVideoPreview": [
        "max-video-preview:-1",
    ],
    "ImageType": [
        "ImageObject",
    ],
    "InLanguage": [
        "en-US",
    ],
    "ItemListElementType": [
        "ListItem",
    ],
    "PotentialActionType": [
        "ReadAction",
        "SearchAction",
    ],
    "QueryInput": [
        "required name=search_term_string",
    ],
    "TargetType": [
        "EntryPoint",
    ],
    "URLTemplate": [
        "https://jp-arts.info/?s={search_term_string}",
    ],
    "Type": [
        "image/jpeg",
    ],
    "Href": [
        "https://api.w.org/{rel}",
    ],
    "Name": [
        "wp",
    ],
    "Taxonomy": [
        "category",
        "post_tag",
    ],
    "OgTitle": [
        "Highlight Archives - JP-Arts",
        "JP-Arts",
    ],
    "GraphType": [
        "BreadcrumbList",
        "CollectionPage",
        "Organization",
        "WebSite",
    ],
};
