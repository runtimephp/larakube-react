import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/app-layout';
import { Head, useForm } from '@inertiajs/react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { MapPin, PinIcon, Server } from 'lucide-react';
import {
    Dialog, DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import React, { FormEventHandler } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cluters',
        href: route('clusters.index'),
    },
];

export default function Clusters() {


    const [open, setOpen] = React.useState(false);

    const { data, setData, post, processing, recentlySuccessful } = useForm({
        name: '',
        region: 'eu-central-ng',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        console.log("Form is being submitted");

        post(route('clusters.index'), {
            preserveScroll: true,
            onSuccess: () => {
                resetForm();
                setOpen(false);
            }
        })

    };

    const resetForm = () => {
        setData('name', '');
        setData('region', 'eu-central-ng');
    }


    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clusters" />

            <div className="px-4 py-6 max-w-5xl mx-auto w-full">
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
                                        <DialogTitle className="text-center">
                                            New Cluster
                                        </DialogTitle>
                                        <DialogDescription className="text-center">
                                            Select a region to deploy a new kubernetes cluster.
                                        </DialogDescription>
                                    </DialogHeader>
                                    <div className="p-8 space-y-6">
                                        <div className="grid w-full items-center gap-2">
                                            <Label htmlFor="name">Cluster Name</Label>
                                            <Input
                                                id="name"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                            />
                                        </div>

                                        <div className="grid w-full items-center gap-1.5">
                                            <Label htmlFor="region">Region</Label>
                                            <p className="text-muted-foreground text-sm">
                                                The physical location of your cluster.
                                            </p>
                                            <Select
                                                value={data.region}
                                                onValueChange={(value) => setData('region', value)}>
                                                <SelectTrigger>
                                                    <div className="flex items-center space-x-3">
                                                        <MapPin /> <SelectValue placeholder="EU Central (Nuremberg)" />
                                                    </div>
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem value={"eu-central-ng"}>EU Central (Nuremberg)</SelectItem>
                                                    <SelectItem value={"eu-central-fs"}>EU Central (Falkenstein)</SelectItem>
                                                    <SelectItem value={"eu-central-hel"}>EU Central (Helsinki)</SelectItem>
                                                    <SelectItem value={"us-west-hb"}>US West (Hillsboro, OR)</SelectItem>
                                                    <SelectItem value={"us-east-va"}>US East (Ashburn, VA)</SelectItem>
                                                    <SelectItem value={"ap-southeast-sg"}>AP South East (Singapore)</SelectItem>
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
                                        <Button
                                            type="submit"
                                            className="cursor-pointer"
                                            onClick={(e) => submit(e)}
                                        >
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
    )
}
