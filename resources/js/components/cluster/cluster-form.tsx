import CloudAccountSelect from '@/components/cloud-account/cloud-account-select';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { CloudAccount, Organization } from '@/types';
import { useForm } from '@inertiajs/react';
import React, { FormEventHandler, useEffect } from 'react';

interface ClusterFormProps {
    organization: Organization;
    cloudAccounts?: CloudAccount[];
}

export default function ClusterForm({ organization, cloudAccounts }: ClusterFormProps) {
    const [availableRegions, setAvailableRegions] = React.useState<Record<string, string>>({});
    const [selectedCloudAccount, setSelectedCloudAccount] = React.useState<CloudAccount | null>(null);
    const { data, setData, post, reset, errors } = useForm({
        name: '',
        region: '',
        cloudAccountId: '',
    });

    useEffect(() => {
        if (selectedCloudAccount?.regions) {
            setAvailableRegions(selectedCloudAccount.regions);

            const regionKeys = Object.keys(selectedCloudAccount.regions);
            if (regionKeys.length > 0 && (!data.region || !selectedCloudAccount.regions[data.region])) {
                setData('region', regionKeys[0]);
            }
        } else {
            setAvailableRegions({});
            setData('region', '');
        }
    }, [data.region, selectedCloudAccount, setData]);

    const handleCloudAccountSelect = (cloudAccountId: string, cloudAccount?: CloudAccount) => {
        setData('cloudAccountId', cloudAccountId);
        setSelectedCloudAccount(cloudAccount || null);
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('clusters.index', { organization: organization?.slug }), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
            },
        });
    };

    return (
        <form onSubmit={submit} className="space-y-6">
            <div className="grid w-full items-center gap-2">
                <Label htmlFor="name">Cluster Name</Label>
                <Input id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                <InputError className="mt-2" message={errors.name} />
            </div>

            <CloudAccountSelect cloudAccounts={cloudAccounts} onSelect={handleCloudAccountSelect} value={data.cloudAccountId} />
            <InputError className="mt-2" message={errors.cloudAccountId} />

            <div className="grid w-full items-center gap-1.5">
                <Label htmlFor="region">Region</Label>
                <p className="text-muted-foreground text-sm">The physical location of your cluster.</p>

                {Object.keys(availableRegions).length > 0 ? (
                    <div>
                        <Select value={data.region} onValueChange={(value) => setData('region', value)}>
                            <SelectTrigger>
                                <div className="flex items-center space-x-3">
                                    <SelectValue placeholder="Select a region" />
                                </div>
                            </SelectTrigger>
                            <SelectContent>
                                {Object.entries(availableRegions).map(([value, label]) => (
                                    <SelectItem key={value} value={value}>
                                        {label}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <InputError className="mt-2" message={errors.region} />
                    </div>
                ) : (
                    <div className="text-muted-foreground py-2 text-sm">No regions available for the selected provider.</div>
                )}
            </div>
            <div className="flex flex-col items-center justify-end gap-2 md:flex-row">
                <Button variant="ghost" className="w-full md:w-auto">
                    Cancel
                </Button>
                <Button type="submit" className="w-full md:w-auto">
                    New Cluster
                </Button>
            </div>
        </form>
    );
}
