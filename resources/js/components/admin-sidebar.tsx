import { Link } from '@inertiajs/react';
import {
    BookOpen,
    ChartPie,
    Folder,
    FolderGit2,
    Group,
    LayoutGrid,
    OctagonAlert,
    Settings,
    Shield,
    TableOfContents,
    User2,
    Users,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavGroup, NavItem } from '@/types';

const adminMainNavItems: NavGroup[] = [
    {
        title: 'Main Menu',
        items: [
            {
                title: 'Dashboard',
                href: dashboard(),
                icon: ChartPie,
            },
            {
                title: 'Manage Users',
                href: '/admin/users',
                icon: Users,
            },
            {
                title: 'Violations',
                href: '/admin/violations',
                icon: OctagonAlert,
            },
            {
                title: 'Folders',
                href: '/admin/folders',
                icon: Folder,
            },
        ],
    },
    {
        title: 'Administration',
        items: [
            {
                title: 'Roles & Permissions',
                href: '/admin/roles',
                icon: Shield,
            },
            {
                title: 'Audit Trails',
                href: '/admin/audit-trails',
                icon: TableOfContents,
            },
            {
                title: 'Settings',
                href: '/admin/settings',
                icon: Settings,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AdminSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={adminMainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
