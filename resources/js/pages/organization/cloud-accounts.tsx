import CloudAccountForm from '@/components/cloud-account/cloud-account-form';
import CloudAccountList from '@/components/cloud-account/cloud-account-list';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import OrganizationLayout from '@/layouts/organization/layout';
import { CloudAccount, SharedData } from '@/types';
import { Head, usePage } from '@inertiajs/react';

interface CloudAccountsProps {
    cloudAccounts: CloudAccount[];
}

export default function CloudAccounts({ cloudAccounts }: CloudAccountsProps) {
    const { organization } = usePage<SharedData>().props;

    const breadcrumbs = [
        {
            title: 'Dashboard',
            href: route('dashboard', { organization: organization?.slug }),
        },
        {
            title: 'Cloud accounts',
            href: route('cloud-accounts.index', { organization: organization?.slug }),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Cloud Accounts" />
            <OrganizationLayout>
                <Card className="max-w-5xl">
                    <CardHeader>
                        <CardTitle>New Cloud Account</CardTitle>
                        <CardDescription>Add a new cloud provider account.</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-8">
                        <CloudAccountForm />
                    </CardContent>
                </Card>
                <CloudAccountList organization={organization} cloudAccounts={cloudAccounts} />
            </OrganizationLayout>
        </AppLayout>
    );
}
