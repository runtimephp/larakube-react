import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { BookOpen, Folder, LayoutGrid, Server } from 'lucide-react';
import OrganizationManager from '@/components/organization/organization-manager';

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        url: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        url: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];

export function AppSidebar() {


    const {organization} = usePage<SharedData>().props;


    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            url: route('dashboard', {organization: organization?.slug}),
            icon: LayoutGrid,
        },
        {
            title: 'Clusters',
            url: route('clusters.index', {organization: organization?.slug}),
            icon: Server,
        }
    ];


    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <OrganizationManager />
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
