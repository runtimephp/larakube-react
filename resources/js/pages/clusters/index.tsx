import CloudAccountIconResolver from '@/components/cloud-account/cloud-account-icon-resolver';
import ClusterForm from '@/components/cluster/cluster-form';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CloudAccount, Cluster, Organization } from '@/types';
import { Head } from '@inertiajs/react';
import { Cloud, MapPin, Server } from 'lucide-react';
import React from 'react';

interface ClustersProps {
    organization: Organization;
    cloudAccounts?: CloudAccount[];
    clusters: Cluster[];
}

export default function Clusters({ organization, cloudAccounts, clusters }: ClustersProps) {
    const [open, setOpen] = React.useState(false);

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

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clusters" />

            <div className="mx-auto w-full max-w-7xl space-y-12 px-4 py-6">
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

                <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    {clusters.map((cluster) => (
                        <Card>
                            <CardHeader>
                                <CardTitle>
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center">
                                            <Server className="mr-2 h-5 w-5" />
                                            <span className="text-sm">{cluster.name}</span>
                                        </div>
                                        <span className="h-5 w-5 shrink-0">
                                            <CloudAccountIconResolver cloudAccount={cluster.cloudAccount} />
                                        </span>
                                    </div>
                                </CardTitle>
                                <CardContent className="-mx-6 mt-2 md:ml-1">
                                    <div className="flex flex-col justify-center space-y-2.5">
                                        <div className="flex items-center space-x-2">
                                            <Cloud className="text-muted-foreground h-5 w-5 shrink-0" />
                                            <span className="text-sm">{cluster.cloudAccount.name}</span>
                                        </div>
                                        <div className="flex items-center space-x-2">
                                            <MapPin className="text-muted-foreground h-5 w-5 shrink-0" />
                                            <div className="text-sm">
                                                <span className="text-ellipsis">{cluster.regionName}</span>
                                            </div>
                                        </div>
                                    </div>
                                </CardContent>
                            </CardHeader>
                        </Card>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
