import type { BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Server } from 'lucide-react';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cluters',
        href: route('clusters.index'),
    },
];

export default function Clusters() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clusters" />

            <div className="px-4 py-6 max-w-5xl mx-auto w-full">
                <Heading title="Clusters" description="Manage your clusters" />
                <div className="flex items-center justify-between">
                    <div>Filters</div>
                    <div>
                        <Dialog modal={true}>
                            <DialogTrigger>
                                <Button>
                                    <Server /> New Cluster
                                </Button>
                            </DialogTrigger>
                            <DialogContent className="sm:max-w-3xl">
                                <DialogHeader>
                                    <DialogTitle className="text-center">
                                        New Cluster
                                    </DialogTitle>
                                    <DialogDescription className="text-center">
                                        Select a region to deploy a new kubernetes cluster.
                                    </DialogDescription>
                                </DialogHeader>
                                <div className="p-8">

                                    <form className="space-y-6">
                                        <div className="grid w-full items-center gap-2">
                                            <Label htmlFor="name">Cluster Name</Label>
                                            <Input id="name" />
                                        </div>

                                        <div className="grid w-full items-center gap-1.5">
                                            <Label htmlFor="name">Region</Label>
                                            <p className="text-muted-foreground text-sm">
                                                The physical location of your cluster.
                                            </p>
                                            <Input id="name" />
                                        </div>
                                    </form>



                                </div>
                                <DialogFooter>
                                    <Button variant="ghost">Cancel</Button>
                                    <Button>New Cluster</Button>
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>

                    </div>
                </div>

            </div>

            </AppLayout>
    )
}
