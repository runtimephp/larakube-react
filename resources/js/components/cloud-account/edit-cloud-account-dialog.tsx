import CloudAccountForm from '@/components/cloud-account/cloud-account-form';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { useCloudAccountDialogStore } from '@/stores/cloud-account-dialog-store';

export default function EditCloudAccountDialog() {
    const { isOpen, close, cloudAccount } = useCloudAccountDialogStore();

    const handleClose = () => {
        close();
    };

    return (
        <Dialog open={isOpen} onOpenChange={handleClose}>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Edit Cloud Account Credentials ({cloudAccount?.name})</DialogTitle>
                    <DialogDescription></DialogDescription>
                </DialogHeader>
                <CloudAccountForm cloudAccount={cloudAccount} operation="update" />
            </DialogContent>
        </Dialog>
    );
}
