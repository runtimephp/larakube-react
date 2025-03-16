import CloudAccountSelect from '@/components/cloud-account/cloud-account-select';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CloudAccount, Organization } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { MapPin, Server } from 'lucide-react';
import React, { FormEventHandler } from 'react';

interface ClustersProps {
    organization: Organization;
    cloudAccounts?: CloudAccount[];
}

export default function Clusters({ organization, cloudAccounts }: ClustersProps) {
    const [open, setOpen] = React.useState(false);

    const { data, setData, post } = useForm({
        name: '',
        provider: '',
        region: 'eu-central-ng',
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
                            <form onSubmit={submit}>
                                <DialogContent className="sm:max-w-3xl">
                                    <DialogHeader>
                                        <DialogTitle className="text-center">New Cluster</DialogTitle>
                                        <DialogDescription className="text-center">
                                            Select a region to deploy a new kubernetes cluster.
                                        </DialogDescription>
                                    </DialogHeader>
                                    <div className="space-y-6 p-8">
                                        <div className="grid w-full items-center gap-2">
                                            <Label htmlFor="name">Cluster Name</Label>
                                            <Input id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                                        </div>

                                        <CloudAccountSelect cloudAccounts={cloudAccounts} />

                                        <div className="grid w-full items-center gap-1.5">
                                            <Label htmlFor="region">Region</Label>
                                            <p className="text-muted-foreground text-sm">The physical location of your cluster.</p>
                                            <Select value={data.region} onValueChange={(value) => setData('region', value)}>
                                                <SelectTrigger>
                                                    <div className="flex items-center space-x-3">
                                                        <MapPin /> <SelectValue placeholder="EU Central (Nuremberg)" />
                                                    </div>
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem value={'eu-central-ng'}>EU Central (Nuremberg)</SelectItem>
                                                    <SelectItem value={'eu-central-fs'}>EU Central (Falkenstein)</SelectItem>
                                                    <SelectItem value={'eu-central-hel'}>EU Central (Helsinki)</SelectItem>
                                                    <SelectItem value={'us-west-hb'}>US West (Hillsboro, OR)</SelectItem>
                                                    <SelectItem value={'us-east-va'}>US East (Ashburn, VA)</SelectItem>
                                                    <SelectItem value={'ap-southeast-sg'}>AP South East (Singapore)</SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                    </div>
                                    <DialogFooter>
                                        <DialogClose asChild>
                                            <Button variant="ghost" onClick={resetForm}>
                                                Cancel
                                            </Button>
                                        </DialogClose>
                                        <Button type="submit" className="cursor-pointer" onClick={(e) => submit(e)}>
                                            New Cluster
                                        </Button>
                                    </DialogFooter>
                                </DialogContent>
                            </form>
                        </Dialog>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
