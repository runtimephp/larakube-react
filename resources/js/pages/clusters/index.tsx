import ClusterForm from '@/components/cluster/cluster-form';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CloudAccount, Organization } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { Server } from 'lucide-react';
import React, { FormEventHandler } from 'react';

interface ClustersProps {
    organization: Organization;
    cloudAccounts?: CloudAccount[];
}

export default function Clusters({ organization, cloudAccounts }: ClustersProps) {
    const [open, setOpen] = React.useState(false);

    const { data, setData, post } = useForm({
        name: '',
        region: 'eu-central-ng',
        cloudAccountId: '',
    });

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard',
            href: route('dashboard', { organization: organization?.slug }),
        },
        {
            title: 'Clusters',
            href: route('clusters.index', { organization: organization?.slug }),
        },
    ];

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('clusters.index', { organization: organization?.slug }), {
            preserveScroll: true,
            onSuccess: () => {
                resetForm();
                setOpen(false);
            },
        });
    };

    const resetForm = () => {
        setData('name', '');
        setData('region', 'eu-central-ng');
        setData('cloudAccountId', cloudAccounts?.length ? cloudAccounts[0].id.toString() : '');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clusters" />

            <div className="mx-auto w-full max-w-7xl px-4 py-6">
                <Heading title="Clusters" description="Manage your clusters" />
                <div className="flex items-center justify-between">
                    <div>Filters</div>
                    <div>
                        <Dialog open={open} onOpenChange={setOpen}>
                            <DialogTrigger>
                                <Button asChild className="cursor-pointer">
                                    <div>
                                        <Server /> New Cluster
                                    </div>
                                </Button>
                            </DialogTrigger>
                            <DialogContent className="sm:max-w-3xl">
                                <DialogHeader>
                                    <DialogTitle className="text-center">New Cluster</DialogTitle>
                                    <DialogDescription className="text-center">Select a region to deploy a new kubernetes cluster.</DialogDescription>
                                </DialogHeader>
                                <ClusterForm organization={organization} cloudAccounts={cloudAccounts} />
                            </DialogContent>
                        </Dialog>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
