import Layout from '@/layouts/cluster/layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { CloudAccount } from '@/types';
import AppLayout from '@/layouts/app-layout';
import { Head } from '@inertiajs/react';

interface Cluster {
    id: number;
    name: string;
    slug: string;
    regionName: string;
    cloudAccount: CloudAccount;
}

interface Props {
    cluster: Cluster;
}

export default function ShowInfrastructure({ cluster }: Props) {
    return (
        <AppLayout>
            <Head title={`${cluster.name} - Infrastructure`} />
            <Layout cluster={cluster}>
                <Card>
                    <CardHeader>
                        <CardTitle>Infrastructure</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-center text-sm text-muted-foreground">No infrastructure components found</div>
                    </CardContent>
                </Card>
            </Layout>
        </AppLayout>
    );
}
