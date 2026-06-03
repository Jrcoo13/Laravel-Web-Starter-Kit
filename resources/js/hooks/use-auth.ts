import { usePage } from '@inertiajs/react';
import type { User } from '@/types';

export function useAuth() {
    const { auth } = usePage<{ auth: { user: User } }>().props;

    return {
        user: auth.user,
        isAuthenticated: !!auth.user,
    };
}
