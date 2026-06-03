import { usePage } from '@inertiajs/react';

export function useRole() {
    const { auth } = usePage<{ auth: { user: { role: { slug: string; name: string } } } }>().props;
    const role = auth.user?.role;

    return {
        role,
        isAdmin: role?.slug === 'admin',
        isUser: role?.slug === 'user',
        hasRole: (roleSlug: string) => role?.slug === roleSlug,
    };
}
