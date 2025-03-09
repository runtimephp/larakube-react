import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useOrganizationDialogStore } from '@/stores/organization-dialog-store';
import type { SharedData } from '@/types';
import { useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function CreateOrganizationDialog() {
    const { isOpen, close } = useOrganizationDialogStore();
    const { organization } = usePage<SharedData>().props;
    const { data, setData, post, processing, reset } = useForm({
        name: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('organizations.store', { organization: organization?.slug }), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                close();
            },
        });
    };

    const handleClose = () => {
        if (!processing) {
            reset();
            close();
        }
    };

    return (
        <Dialog open={isOpen} onOpenChange={handleClose}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Create New Organization</DialogTitle>
                    <DialogDescription>Add a new organization to your account.</DialogDescription>
                </DialogHeader>
                <form onSubmit={submit}>
                    <div className="grid gap-4 py-4">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Organization Name</Label>
                            <Input
                                id="name"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                placeholder="Enter organization name"
                                required
                                minLength={3}
                                disabled={processing}
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button type="button" variant="secondary" onClick={handleClose} disabled={processing}>
                            Cancel
                        </Button>
                        <Button type="submit" disabled={processing || !data.name.trim() || data.name.length < 3}>
                            {processing ? 'Creating...' : 'Create Organization'}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
}
