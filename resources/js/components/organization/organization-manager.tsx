import { router, usePage } from '@inertiajs/react';
import type { SharedData } from '@/types';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { SidebarMenuButton } from '@/components/ui/sidebar';
import { useInitials } from '@/hooks/use-initials';
import { Check, ChevronsUpDown, PlusCircle } from 'lucide-react';
import {
    Command,
    CommandEmpty, CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator
} from '@/components/ui/command';
import React from 'react';
import { useOrganizationDialogStore } from '@/stores/organization-dialog-store';



export default function OrganizationManager() {
    const [open, setOpen] = React.useState(false);
    const openCreateDialog = useOrganizationDialogStore(state => state.open);
    const getInitials = useInitials()
    const { organizations, organization: currentOrganization } = usePage<SharedData>().props;

    const switchOrganization = (slug: string) =>
    {

        setOpen(false);
        const url = route('organizations.switch', { organization: currentOrganization?.slug });
        router.post(
            url,
            {
                slug: slug,
                routeName: route().current()
            });

    }

    const handleCreateOrganization = () => {
        setOpen(false);
        openCreateDialog();
    };

    return (
        <DropdownMenu open={open} onOpenChange={setOpen}>
            <DropdownMenuTrigger asChild>
                <SidebarMenuButton
                    size="lg"
                    className="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                    <div className="bg-primary text-primary-foreground flex aspect-square size-8 items-center justify-center rounded-lg">
                        {getInitials(currentOrganization?.name ?? 'LK')}
                    </div>
                    <div className="grid flex-1 text-left text-sm leading-tight">
                        <span className="truncate font-semibold">{currentOrganization?.name}</span>
                        <span className="truncate text-xs">Manage Organizations</span>
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
                                {organizations?.map((organization) => (
                                    <CommandItem
                                        key={organization.id}

                                    >
                                        <div
                                            className="flex items-center justify-between space-x-2 w-full cursor-pointer"
                                            onClick={() => switchOrganization(organization.slug)}
                                        >
                                            <div className="flex items-center space-x-2">
                                                <div className="bg-primary text-primary-foreground flex aspect-square size-6 items-center justify-center rounded-sm text-xs">
                                                    {getInitials(organization.name)}
                                                </div>
                                                <div className="truncate max-w-30">{organization.name}</div>
                                            </div>
                                            <div className="item">
                                                {organization.slug === currentOrganization?.slug ? (
                                                    <Check />
                                                ) : null}
                                            </div>
                                        </div>
                                    </CommandItem>
                                ))}

                        </CommandGroup>
                    <CommandSeparator />
                    <CommandGroup heading="Manage organization">
                        <CommandItem>
                            Organization Settings
                        </CommandItem>
                        <CommandItem
                            className="cursor-pointer"
                            onSelect={handleCreateOrganization}>
                            <div className="flex items-center">
                                <PlusCircle className="mr-2 h-4 w-4" />
                                Create New Organization
                            </div>
                        </CommandItem>
                    </CommandGroup>
                    </CommandList>
                </Command>

            </DropdownMenuContent>

        </DropdownMenu>
    );



};
