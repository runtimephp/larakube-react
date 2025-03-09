import { router, usePage } from '@inertiajs/react';
import type { SharedData } from '@/types';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenuButton } from '@/components/ui/sidebar';
import { useInitials } from '@/hooks/use-initials';
import { ChevronsUpDown } from 'lucide-react';
import {
    Command,
    CommandEmpty, CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator
} from '@/components/ui/command';
import React from 'react';



export default function OrganizationManager() {
    const [open, setOpen] = React.useState(false);
    const getInitials = useInitials()
    const { organizations, organization } = usePage<SharedData>().props;

    const switchOrganization = (slug: string) =>
    {

        setOpen(false);
        const url = route('organizations.switch', { organization: organization?.slug });
        router.post(
            url,
            {
                slug: slug,
                routeName: route().current()
            });

    }

    return (
        <DropdownMenu open={open} onOpenChange={setOpen}>
            <DropdownMenuTrigger asChild>
                <SidebarMenuButton
                    size="lg"
                    className="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                    <div className="bg-primary text-primary-foreground flex aspect-square size-8 items-center justify-center rounded-lg">
                        {getInitials(organization?.name ?? 'LK')}
                    </div>
                    <div className="grid flex-1 text-left text-sm leading-tight">
                        <span className="truncate font-semibold">{organization?.name}</span>
                        <span className="truncate text-xs">Manage Organization</span>
                    </div>
                    <ChevronsUpDown />
                </SidebarMenuButton>
            </DropdownMenuTrigger>
            <DropdownMenuContent
                className="w-(--radix-dropdown-menu-trigger-width) min-w-56 rounded-lg p-0"
                align="start"
                side="bottom">
                <Command>
                    <CommandInput placeholder="Search organizations" />
                    <CommandList>
                        <CommandEmpty>
                            No organizations found
                        </CommandEmpty>
                        <CommandGroup heading="Switch organization">
                                {organizations?.map((org) => (
                                    <CommandItem
                                        key={org.id}
                                        disabled={org.id === organization?.id}

                                    >
                                        <div onClick={() => switchOrganization(org.slug)}>
                                            {org.name}
                                        </div>
                                    </CommandItem>
                                ))}

                        </CommandGroup>
                    <CommandSeparator />
                    <CommandGroup heading="Manage organization">
                        <CommandItem>
                            Organization Settings
                        </CommandItem>
                        <CommandItem>
                            <div>Create New Organization</div>
                        </CommandItem>
                    </CommandGroup>
                    </CommandList>
                </Command>

            </DropdownMenuContent>

        </DropdownMenu>
    );



};
