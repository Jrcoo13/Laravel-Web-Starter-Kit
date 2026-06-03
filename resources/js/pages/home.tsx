import { Head } from '@inertiajs/react';
import { useAuth } from '@/hooks/use-auth';

export default function Home() {
    const { user } = useAuth();

    return (
        <>
            <Head title="Home" />
            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                <div className="space-y-2">
                    <h1 className="text-3xl font-bold tracking-tight">
                        Welcome back, {user.first_name || user.name}! 👋
                    </h1>
                    <p className="text-muted-foreground">
                        This is your personal dashboard. You can manage your profile and account settings from the sidebar.
                    </p>
                </div>

                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div className="rounded-xl border bg-card p-6 shadow-sm">
                        <div className="flex items-center gap-4">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    className="h-6 w-6 text-primary"
                                >
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </div>
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Profile</p>
                                <h3 className="text-2xl font-bold">Complete</h3>
                            </div>
                        </div>
                        <p className="mt-4 text-sm text-muted-foreground">
                            Your profile information is up to date.
                        </p>
                    </div>

                    <div className="rounded-xl border bg-card p-6 shadow-sm">
                        <div className="flex items-center gap-4">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-green-500/10">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    className="h-6 w-6 text-green-600 dark:text-green-500"
                                >
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                    <polyline points="22 4 12 14.01 9 11.01" />
                                </svg>
                            </div>
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Account Status</p>
                                <h3 className="text-2xl font-bold">Active</h3>
                            </div>
                        </div>
                        <p className="mt-4 text-sm text-muted-foreground">
                            Your account is in good standing.
                        </p>
                    </div>

                    <div className="rounded-xl border bg-card p-6 shadow-sm">
                        <div className="flex items-center gap-4">
                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500/10">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    className="h-6 w-6 text-blue-600 dark:text-blue-500"
                                >
                                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </div>
                            <div>
                                <p className="text-sm font-medium text-muted-foreground">Settings</p>
                                <h3 className="text-2xl font-bold">Manage</h3>
                            </div>
                        </div>
                        <p className="mt-4 text-sm text-muted-foreground">
                            Configure your preferences and security.
                        </p>
                    </div>
                </div>

                <div className="rounded-xl border bg-card p-6 shadow-sm">
                    <h2 className="mb-4 text-xl font-semibold">Quick Actions</h2>
                    <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <a
                            href="/settings/profile"
                            className="flex items-center gap-3 rounded-lg border p-4 transition-colors hover:bg-accent"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                className="h-5 w-5 text-muted-foreground"
                            >
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            <div>
                                <p className="font-medium">Edit Profile</p>
                                <p className="text-xs text-muted-foreground">Update your information</p>
                            </div>
                        </a>

                        <a
                            href="/settings/security"
                            className="flex items-center gap-3 rounded-lg border p-4 transition-colors hover:bg-accent"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                className="h-5 w-5 text-muted-foreground"
                            >
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <div>
                                <p className="font-medium">Security</p>
                                <p className="text-xs text-muted-foreground">Manage password & 2FA</p>
                            </div>
                        </a>

                        <a
                            href="/settings/account"
                            className="flex items-center gap-3 rounded-lg border p-4 transition-colors hover:bg-accent"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                className="h-5 w-5 text-muted-foreground"
                            >
                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <div>
                                <p className="font-medium">Account Settings</p>
                                <p className="text-xs text-muted-foreground">Preferences & privacy</p>
                            </div>
                        </a>

                        <a
                            href="/settings/sessions"
                            className="flex items-center gap-3 rounded-lg border p-4 transition-colors hover:bg-accent"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                className="h-5 w-5 text-muted-foreground"
                            >
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                <path d="M9 3v18" />
                            </svg>
                            <div>
                                <p className="font-medium">Sessions</p>
                                <p className="text-xs text-muted-foreground">Active devices</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </>
    );
}

Home.layout = {
    breadcrumbs: [
        {
            title: 'Home',
            href: '/home',
        },
    ],
};
