import Layout from '@/layouts/cluster/layout';
import { Card, CardContent } from '@/components/ui/card';
import { CloudAccount } from '@/types';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

interface Cluster {
    id: number;
    name: string;
    slug: string;
    regionName: string;
    cloudAccount: CloudAccount;
    created_at: string;
}

interface Props {
    cluster: Cluster;
}

export default function ShowCluster({ cluster }: Props) {
    return (
        <AppLayout>
            <Head title={cluster.name} />
            <Layout cluster={cluster}>
                <Card>
                    <CardContent className="p-6">
                        <div className="grid gap-6">
                            <div className="grid grid-cols-2 gap-6">
                                <div className="space-y-1">
                                    <div className="text-sm text-muted-foreground">Cloud Provider</div>
                                    <div>{cluster.cloudAccount.providerName}</div>
                                </div>
                                <div className="space-y-1">
                                    <div className="text-sm text-muted-foreground">Kubernetes Version</div>
                                    <div>1.29.1</div>
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-6">
                                <div className="space-y-1">
                                    <div className="text-sm text-muted-foreground">Distribution</div>
                                    <div>k3s</div>
                                </div>
                                <div className="space-y-1">
                                    <div className="text-sm text-muted-foreground">Quick Deploy</div>
                                    <div>Disabled</div>
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-6">
                                <div className="space-y-1">
                                    <div className="text-sm text-muted-foreground">Region</div>
                                    <div>{cluster.regionName}</div>
                                </div>
                                <div className="space-y-1">
                                    <div className="text-sm text-muted-foreground">Last Deployed</div>
                                    <div>{new Date(cluster.created_at).toLocaleString()}</div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </Layout>
        </AppLayout>
    );
}
