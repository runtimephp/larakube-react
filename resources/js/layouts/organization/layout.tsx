import CloudAccountDialogs from '@/components/cloud-account/cloud-accout-dialogs';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { cn } from '@/lib/utils';
import { type NavItem, SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';

export default function OrganizationLayout({ children }: PropsWithChildren) {
    const currentPath = window.location.pathname;
    const { organization } = usePage<SharedData>().props;

    const sidebarNavItems: NavItem[] = [
        {
            title: 'Cloud Accounts',
            url: route('cloud-accounts.index', { organization: organization?.slug }),
            icon: null,
        },
        {
            title: 'Members',
            url: '/settings/password',
            icon: null,
        },
        {
            title: 'Billing',
            url: '/settings/appearance',
            icon: null,
        },
    ];

    return (
        <div className="mx-auto w-full max-w-7xl px-4 py-6">
            <Heading title={organization?.name + ' Settings'} description="Manage your organization settings" />

            <div className="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <aside className="w-full max-w-xl lg:w-48">
                    <nav className="flex flex-col space-y-1 space-x-0">
                        {sidebarNavItems.map((item) => (
                            <Button
                                key={item.url}
                                size="sm"
                                variant="ghost"
                                asChild
                                className={cn('w-full justify-start', {
                                    'bg-muted': currentPath === item.url,
                                })}
                            >
                                <Link href={item.url} prefetch>
                                    {item.title}
                                </Link>
                            </Button>
                        ))}
                    </nav>
                </aside>

                <Separator className="my-6 md:hidden" />

                <div className="w-full flex-1">
                    <section className="max-w-5xl space-y-12">{children}</section>
                </div>
            </div>
            <CloudAccountDialogs />
        </div>
    );
}
