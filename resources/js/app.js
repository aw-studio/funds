import.meta.glob(["../fonts/**"]);
import "./bootstrap";

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
