import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import List from "@editorjs/list";
// import LinkTool from "@editorjs/link";
import Quote from "@editorjs/quote";
// import RawTool from "@editorjs/raw";
// import SimpleImage from "@editorjs/simple-image";
import Image from "@editorjs/image";
import Checklist from "@editorjs/checklist";
// import Embed from "@editorjs/embed";
import Delimiter from "@editorjs/delimiter";
import { MyBlockTune } from "./editor/tunes";
import { Embed } from "./editor/embed";
import localization from "./localization.json";

// The Default Embed is "Paste Only" - This is a custom Embed Tool also allows
// the user to enter a URL manually.

window.addEventListener("DOMContentLoaded", (event) => {
    const data = JSON.parse(document.getElementById("content").value || "{}");
    // console.log(document.getElementById("content").value);

    const editor = new EditorJS({
        holder: "editorjs",
        placeholder: "Let`s write an awesome story!",
        onReady: (e) => {},
        i18n: {
            messages: {
                ...localization,
            },
        },
        tools: {
            // header
            header: {
                class: Header,
                inlineToolbar: true,
                config: {
                    placeholder: "Enter a header",
                    levels: [2, 3, 4],
                    defaultLevel: 3,
                },
            },

            // list
            list: {
                class: List,
                inlineToolbar: true,
                config: {
                    defaultStyle: "unordered",
                },
            },

            // quote
            quote: Quote,

            // delimiter
            delimiter: Delimiter,

            // image
            // image: SimpleImage,
            image: {
                class: Image,
                config: {
                    endpoints: {
                        byFile: window.location + "/upload-image", // Your backend file uploader endpoint
                        // byUrl: "/api/fetch-image", // Your endpoint that provides uploading by Url
                    },
                    additionalRequestHeaders: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    actions: [],
                },
            },

            // checklist
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },

            // embed
            embed: {
                class: Embed,
                config: {
                    services: {
                        youtube: true,
                        vimeo: true,
                    },
                },
            },
        },

        onChange: function () {
            editor
                .save()
                .then((data) => {
                    document.getElementById("content").value =
                        JSON.stringify(data);
                    console.log("Saving successful: ", data);
                })
                .catch((error) => {
                    console.error("Saving failed: ", error);
                });
        },

        data: data,
    });

    window.editor = editor;
});
