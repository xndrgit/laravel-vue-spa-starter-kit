export function validationErrors(error, fallback) {
    return error.response?.data?.errors || fallback;
}
