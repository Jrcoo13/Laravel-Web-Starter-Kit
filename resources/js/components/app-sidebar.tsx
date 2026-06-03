import { AdminSidebar } from '@/components/admin-sidebar';
import { UserSidebar } from '@/components/user-sidebar';
import { useRole } from '@/hooks/use-role';

export function AppSidebar() {
    const { isAdmin } = useRole();

    // Render role-specific sidebar
    if (isAdmin) {
        return <AdminSidebar />;
    }

    return <UserSidebar />;
}
