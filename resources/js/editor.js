import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import List from "@editorjs/list";
// import LinkTool from "@editorjs/link";
import Quote from "@editorjs/quote";
// import RawTool from "@editorjs/raw";
// import SimpleImage from "@editorjs/simple-image";
import Image from "@editorjs/image";
import Checklist from "@editorjs/checklist";
import EmbedTool from "@editorjs/embed";
import Delimiter from "@editorjs/delimiter";

// The Default Embed is "Paste Only" - This is a custom Embed Tool also allows
// the user to enter a URL manually.
class Embed extends EmbedTool {
    static get toolbox() {
        return {
            title: "YouTube",
            icon: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-youtube w-6 h-6 mx-1"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"></path><path d="m10 15 5-3-5-3z"></path></svg>',
        };
    }

    /**
     * Render Embed tool content
     *
     * @returns {HTMLElement}
     */
    render() {
        if (!this.data.service) {
            const container = document.createElement("div");

            this.element = container;
            const input = document.createElement("input");
            input.classList.add("cdx-input");
            input.placeholder = "https://www.youtube.com/watch?v=w8vsuOXZBXc";
            input.type = "url";
            input.addEventListener("paste", (event) => {
                const url = event.clipboardData.getData("text");
                const service = Object.keys(Embed.services).find((key) =>
                    Embed.services[key].regex.test(url)
                );
                if (service) {
                    this.onPaste({ detail: { key: service, data: url } });
                }
            });
            container.appendChild(input);

            return container;
        }
        return super.render();
    }

    validate(savedData) {
        return savedData.service && savedData.source ? true : false;
    }
}
window.addEventListener("DOMContentLoaded", (event) => {
    const data = JSON.parse(document.getElementById("content").value || "{}");
    console.log(document.getElementById("content").value);

    const editor = new EditorJS({
        holder: "editorjs",

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
                    additionalRequestData: {
                        foo: "bar", // Your additional request data
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
