import.meta.glob(["../fonts/**"]);
import "./bootstrap";

Alpine.directive(
    "money",
    (el, { expression, modifiers }, { evaluateLater, effect }) => {
        const getValue = evaluateLater(expression);
        effect(() => {
            getValue((moneyValue) => {
                if (!moneyValue) {
                    return;
                }
                const formattedMoney = moneyValue / 100;
                const formattedPrice = new Intl.NumberFormat("de", {
                    style: "currency",
                    currency: "EUR",
                }).format(formattedMoney);

                el.innerText = formattedPrice;
            });
        });
    }
);
