import Layout from '@/layouts/cluster/layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { CloudAccount, Deployment } from '@/types';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

interface Cluster {
    id: number;
    name: string;
    slug: string;
    regionName: string;
    cloudAccount: CloudAccount;
}

interface PaginatedData<T> {
    data: T[];
    current_page: number;
    per_page: number;
    total: number;
}

interface Props {
    cluster: Cluster;
    deployments: PaginatedData<Deployment>;
}

export default function ShowDeployments({ cluster, deployments }: Props) {
    return (
        <AppLayout>
            <Head title={`${cluster.name} - Deployments`} />
            <Layout cluster={cluster}>
                <Card>
                    <CardHeader>
                        <CardTitle>Deployments</CardTitle>
                    </CardHeader>
                    <CardContent>
                        {deployments.data.length === 0 ? (
                            <div className="text-center text-sm text-muted-foreground">No deployments found</div>
                        ) : (
                            <div className="space-y-4">
                                {deployments.data.map((deployment) => (
                                    <div key={deployment.id} className="flex items-center justify-between">
                                        <div>
                                            <div className="font-medium">{deployment.name}</div>
                                            <div className="text-sm text-muted-foreground">{deployment.status}</div>
                                        </div>
                                        <div className="text-sm text-muted-foreground">
                                            {new Date(deployment.created_at).toLocaleDateString()}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </Layout>
        </AppLayout>
    );
}
