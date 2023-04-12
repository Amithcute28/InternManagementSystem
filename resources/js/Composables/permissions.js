import { usePage } from "@inertiajs/vue3";

export function usePermission(){
    const hasRole = (name) => usePage().props.auth.user.roles.includes(name);
    const hasPermissions = (name) => usePage().props.auth.user.permissions.includes(name);

    return { hasRole, hasPermissions};
}