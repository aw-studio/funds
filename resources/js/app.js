import.meta.glob(["../fonts/**"]);
import "./bootstrap";
import "@wotz/livewire-sortablejs";

Alpine.directive(
    "money",
    (el, { expression, modifiers }, { evaluateLater, effect }) => {
        const getValue = evaluateLater(expression);
        effect(() => {
            getValue((moneyValue) => {
                const formattedMoney = moneyValue / 100;
                // TODO - Add support for other currencies
                const formattedPrice = new Intl.NumberFormat("de", {
                    style: "currency",
                    currency: "EUR",
                }).format(formattedMoney);

                el.innerText = formattedPrice;
            });
        });
    }
);

Alpine.data("imageInput", (initialUrl) => ({
    imageUrl: initialUrl,
    hasChanged: false,
    shouldDelete: false,
    init() {
        this.$watch("imageUrl", (value) => {});
    },

    clear() {
        this.imageUrl = "";
        this.shouldDelete = true;
        this.hasChanged = true;
    },

    selectFile(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        if (event.target.files.length < 1) {
            return;
        }

        reader.readAsDataURL(file);

        reader.onload = () => (this.imageUrl = reader.result);
        this.hasChanged = true;
    },
}));
