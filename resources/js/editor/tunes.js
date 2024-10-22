export class MyBlockTune {
    static isTune = true;

    enabled = false;
    constructor({ api, data, config, block }) {
        this.api = api;
        this.data = data;
        this.config = config;
        this.block = block;
    }

    render() {
        return {
            icon: this.enabled
                ? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
  <path d="M18.25 3A2.75 2.75 0 0 1 21 5.75v12.5A2.75 2.75 0 0 1 18.25 21H5.75A2.75 2.75 0 0 1 3 18.25V5.75A2.75 2.75 0 0 1 5.75 3h12.5Zm0 1.5H5.75c-.69 0-1.25.56-1.25 1.25v12.5c0 .69.56 1.25 1.25 1.25h12.5c.69 0 1.25-.56 1.25-1.25V5.75c0-.69-.56-1.25-1.25-1.25ZM10 14.44l6.47-6.47a.75.75 0 0 1 1.133.976l-.073.084-7 7a.75.75 0 0 1-.976.073l-.084-.073-3-3a.75.75 0 0 1 .976-1.133l.084.073L10 14.44l6.47-6.47L10 14.44Z" fill="#212121" fill-rule="nonzero"/>
</svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
  <path d="M5.75 3h12.5A2.75 2.75 0 0 1 21 5.75v12.5A2.75 2.75 0 0 1 18.25 21H5.75A2.75 2.75 0 0 1 3 18.25V5.75A2.75 2.75 0 0 1 5.75 3Zm0 1.5c-.69 0-1.25.56-1.25 1.25v12.5c0 .69.56 1.25 1.25 1.25h12.5c.69 0 1.25-.56 1.25-1.25V5.75c0-.69-.56-1.25-1.25-1.25H5.75Z" fill="#212121" fill-rule="nonzero"/>
</svg>`,
            label: "Gdpr Embed",
            onActivate: () => {
                console.log("foo");
                // this.enabled = !this.enabled;
                // this.block.safeload = this.enabled;
                // console.log("onActivate");
                // console.log(this.block);
                // this.block.dispatchChange();
                // this.changeBlockText(); // Keep this as it was
                this.data["some-property"] = "some-value";
                this.block.dispatchChange();
            },
        };
    }
    changeBlockText() {
        console.log("foo");
    }
    // save() {
    //     //     console.log("save");
    //     // this.block.foo = "bar";
    //     //     return {
    //     //         enabled: this.enabled,
    //     //     };
    // }
}
