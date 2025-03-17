import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { cn } from '@/lib/utils';
import { type NavItem, SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { type PropsWithChildren } from 'react';
import { ChevronLeft } from 'lucide-react';
import Heading from '@/components/heading';

interface LayoutProps extends PropsWithChildren {
    cluster: {
        id: number;
        name: string;
        slug: string;
    };
}

export default function ClusterLayout({ children, cluster }: LayoutProps) {
    const currentPath = window.location.pathname;
    const { organization } = usePage<SharedData>().props;

    const sidebarNavItems: NavItem[] = [
        {
            title: 'Overview',
            url: route('clusters.show', { organization: organization?.slug, cluster: cluster.slug }),
            icon: null,
        },
        {
            title: 'Deployments',
            url: route('clusters.deployments', { organization: organization?.slug, cluster: cluster.slug }),
            icon: null,
        },
        {
            title: 'Infrastructure',
            url: route('clusters.infrastructure', { organization: organization?.slug, cluster: cluster.slug }),
            icon: null,
        },
    ];

    return (
        <div className="mx-auto w-full max-w-svw space-y-6 px-4 py-6 md:max-w-7xl">
            <div className="space-y-2">
                <Link
                    href={route('clusters.index', { organization: organization?.slug })}
                    className="inline-flex items-center text-sm text-muted-foreground hover:text-foreground"
                >
                    <ChevronLeft className="mr-2 h-4 w-4" />
                    Back to clusters
                </Link>
                <Heading title={cluster.name} description={`Cluster #${cluster.id}`} />
            </div>

            <div className="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <aside className="w-full lg:w-48">
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
                    <section className="max-w-screen space-y-12 md:max-w-5xl">{children}</section>
                </div>
            </div>
        </div>
    );
}
