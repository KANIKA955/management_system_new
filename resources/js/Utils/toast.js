import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const defaultOptions = {
    autoClose: 3000,
    position: "top-right",
    theme: "colored",
    closeOnClick: true,
    pauseOnHover: true,
    draggable: true,
};

const createToast = (type) => (message, options = {}) => {
    const finalOptions = { ...defaultOptions, ...options };
    toast[type](message, finalOptions);
};

const Toast = {
    success: createToast("success"),
    error: createToast("error"),
    info: createToast("info"),
    warning: createToast("warning"),
    default: createToast("default"),
};

export default Toast;
