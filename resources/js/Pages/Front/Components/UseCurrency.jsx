import { usePage } from "@inertiajs/react";
import { useMemo } from "react";
export function UseCurrency() {
    const { current_currency } = usePage().props;

    // Memoize conversion function to avoid recalculating every render
    const currency = useMemo(() => {
        const rate = current_currency?.rate ?? 1;
        const symbol = current_currency?.symbol ?? "$";
        // Convert price helper
        const convertPrice = (price) => {
            if (!price || isNaN(price)) return "0.00";
            return (parseFloat(price) * rate).toFixed(2);
        };
        return {
            symbol,
            convertPrice,
            code: current_currency?.code ?? "USD",
            rate,
        };
    }, [current_currency]);
    return currency;
}