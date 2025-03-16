import InputError from '@/components/input-error';
import DigitalOceanLogo from '@/components/logos/digital-ocean';
import HetznerLogo from '@/components/logos/hetzner';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { useCloudAccountDialogStore } from '@/stores/cloud-account-dialog-store';
import { CloudAccount, SharedData } from '@/types';
import { useForm, usePage } from '@inertiajs/react';
import { FormEventHandler, MouseEvent } from 'react';

interface CloudAccountFormProps {
    cloudAccount?: CloudAccount;
    operation?: 'create' | 'update';
}

type CloudAccountFormData = {
    provider: string;
    name: string;
    key: string;
};

export default function CloudAccountForm({ cloudAccount, operation = 'create' }: CloudAccountFormProps) {
    const { close } = useCloudAccountDialogStore();
    const { organization } = usePage<SharedData>().props;
    const { data, setData, post, patch, errors, processing, reset } = useForm<CloudAccountFormData>({
        provider: cloudAccount?.provider || 'hetzner',
        name: cloudAccount?.name || '',
        key: (cloudAccount?.config?.key as string) || '',
    });

    const handleCancel = (e: MouseEvent) => {
        e.preventDefault();
        reset();
        close();
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        if (operation === 'update') {
            patch(route('cloud-accounts.update', { organization: organization?.slug, cloudAccount: cloudAccount?.id }), {
                preserveScroll: true,
                onSuccess: () => {
                    close();
                },
            });
            return;
        }

        if (operation === 'create') {
            post(route('cloud-accounts.store', { organization: organization?.slug }), {
                preserveScroll: true,
                onSuccess: () => {
                    reset();
                },
            });
        }
    };

    return (
        <form onSubmit={submit}>
            <div className="space-y-6">
                <div className="grid gap-4">
                    {operation === 'create' && (
                        <RadioGroup
                            onValueChange={(value) => setData('provider', value)}
                            defaultValue={data.provider}
                            className="grid grid-cols-2 gap-4 md:grid-cols-5"
                        >
                            <div>
                                <RadioGroupItem value="hetzner" id="hetzner" className="peer sr-only" aria-label="Hetzner" />
                                <Label
                                    htmlFor="hetzner"
                                    className="border-muted hover:bg-accent hover:text-accent-foreground peer-data-[state=checked]:border-primary [&:has([data-state=checked])]:border-primary cursor flex flex-col items-center justify-between space-y-2.5 rounded-md border-2 bg-transparent p-4"
                                >
                                    <HetznerLogo className="h-12 w-12 rounded-xs" />
                                    <span className="text-muted-foreground">Hetzner Cloud</span>
                                </Label>
                            </div>
                            <div>
                                <RadioGroupItem value="digitalocean" id="digitalocean" className="peer sr-only" aria-label="DigitalOcean" />
                                <Label
                                    htmlFor="digitalocean"
                                    className="border-muted hover:bg-accent hover:text-accent-foreground peer-data-[state=checked]:border-primary [&:has([data-state=checked])]:border-primary cursor flex flex-col items-center justify-between space-y-2.5 rounded-md border-2 bg-transparent p-4"
                                >
                                    <DigitalOceanLogo className="h-12 w-12 rounded-xs" />
                                    <span className="text-muted-foreground">DigitalOcean</span>
                                </Label>
                            </div>
                        </RadioGroup>
                    )}

                    <div className="grid gap-4">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Profile Name</Label>

                            <Input
                                id="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                placeholder="project name"
                                disabled={processing}
                            />

                            <InputError className="mt-2" message={errors.name} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="key">APi Key</Label>

                            <Input id="key" value={data.key} type="password" onChange={(e) => setData('key', e.target.value)} disabled={processing} />

                            <InputError className="mt-2" message={errors.key} />
                        </div>
                    </div>
                </div>
                <div className="flex items-center justify-end space-x-4">
                    {operation === 'update' && (
                        <Button variant="secondary" onClick={(e) => handleCancel(e)} disabled={processing}>
                            Cancel
                        </Button>
                    )}
                    <Button type="submit">
                        {processing ? (operation === 'create' ? 'Creating...' : 'Saving...') : operation === 'create' ? 'Add' : 'Save'}
                    </Button>
                </div>
            </div>
        </form>
    );
}
