import { useCallback } from "react";
import { useNavigate } from "react-router-dom";
import { createRoot } from "react-dom/client";
import { AppProvider } from "@shopify/polaris";
import "@shopify/polaris/build/esm/styles.css";
// import List from "./component/List";
import translations from "@shopify/polaris/locales/en.json";
// import Plan from "./component/Plan/index";
// import { NavMenu } from "@shopify/app-bridge-react";
// import Routes from "./Routes";
// import "./../css/app.css";

const AppBridgeLink = ({ url, children, external, ...rest }) => {
    const navigate = useNavigate();
    const handleClick = useCallback(() => {
        navigate(url);
    }, [url]);

    const IS_EXTERNAL_LINK_REGEX = /^(?:[a-z][a-z\d+.-]*:|\/\/)/;

    if (external || IS_EXTERNAL_LINK_REGEX.test(url)) {
        return (
            <a target="_blank" rel="noopener noreferrer" href={url} {...rest}>
                {children}
            </a>
        );
    }

    return (
        <a onClick={handleClick} {...rest}>
            {children}
        </a>
    );
};

export default function App() {
    return (
        <AppProvider i18n={translations} linkComponent={AppBridgeLink}>
            <h1>heelo</h1>
        </AppProvider>
    );
}

if (document.getElementById("root")) {
    createRoot(document.getElementById("root")).render(<App />);
}
