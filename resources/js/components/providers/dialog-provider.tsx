// components/providers/dialog-provider.tsx

import ConfirmationDialog from '@/components/confirmation-dialog';
import { useConfirmationDialogStore } from '@/stores/confirmation-dialog-store';

export function DialogProvider() {
    const { isOpen, title, description, confirmText, cancelText, variant, onConfirm, close } = useConfirmationDialogStore();

    const handleConfirm = () => {
        onConfirm();
        close();
    };

    return (
        <ConfirmationDialog
            isOpen={isOpen}
            onClose={close}
            onConfirm={handleConfirm}
            title={title}
            description={description}
            confirmText={confirmText}
            cancelText={cancelText}
            variant={variant}
        />
    );
}
