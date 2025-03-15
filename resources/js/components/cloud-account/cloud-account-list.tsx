import DigitalOceanLogo from '@/components/logos/digital-ocean';
import HetznerLogo from '@/components/logos/hetzner';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useCloudAccountDialogStore } from '@/stores/cloud-account-dialog-store';
import { useConfirmationDialogStore } from '@/stores/confirmation-dialog-store';
import { CloudAccount, Organization } from '@/types';
import { router } from '@inertiajs/react';

interface CloudAccountListProps {
    organization?: Organization;
    cloudAccounts?: CloudAccount[];
}

export default function CloudAccountList({ organization, cloudAccounts }: CloudAccountListProps) {
    const { open: openCloudAccountForm } = useCloudAccountDialogStore();
    const { open: openConfirmationDialog } = useConfirmationDialogStore();

    const handleAccountDelete = (cloudAccount: CloudAccount) => {
        openConfirmationDialog({
            title: 'Delete Cloud Account',
            description: 'Are you sure you want to delete this cloud account?',
            confirmText: 'Delete',
            cancelText: 'Cancel',
            variant: 'destructive',
            onConfirm: () => {
                router.delete(route('cloud-accounts.destroy', { organization: organization?.slug, cloudAccount: cloudAccount.id }), {
                    preserveScroll: true,
                });
            },
        });
    };

    return (
        <Card>
            <CardHeader>
                <CardTitle>Active Cloud Accounts</CardTitle>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead className="w-10">ID</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Provider</TableHead>
                            <TableHead>In Use?</TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {cloudAccounts?.map((cloudAccount) => (
                            <TableRow key={cloudAccount.id}>
                                <TableCell>{cloudAccount.id}</TableCell>
                                <TableCell>{cloudAccount.name}</TableCell>
                                <TableCell>
                                    <div className="flex items-center space-x-2">
                                        {cloudAccount.provider === 'hetzner' ? (
                                            <HetznerLogo className="h-5 w-5 rounded-xs" />
                                        ) : (
                                            <DigitalOceanLogo className="h-5 w-5 rounded-xs" />
                                        )}
                                        <span>{cloudAccount.providerName}</span>
                                    </div>
                                </TableCell>
                                <TableCell></TableCell>
                                <TableCell className="flex items-center justify-end space-x-2">
                                    <Button variant="ghost" size="sm" onClick={() => handleAccountDelete(cloudAccount)}>
                                        <span className="font-semibold text-red-500">Delete</span>
                                    </Button>
                                    <Button variant="ghost" size="sm" onClick={() => openCloudAccountForm(cloudAccount)}>
                                        Edit
                                    </Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    );
}
