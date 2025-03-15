// stores/confirmation-dialog-store.ts
import { create } from 'zustand';

type ConfirmationDialogStore = {
    isOpen: boolean;
    title: string;
    description: string;
    confirmText: string;
    cancelText: string;
    variant: 'default' | 'destructive';
    onConfirm: () => void;
    open: (props: {
        title: string;
        description: string;
        confirmText?: string;
        cancelText?: string;
        variant?: 'default' | 'destructive';
        onConfirm: () => void;
    }) => void;
    close: () => void;
};

export const useConfirmationDialogStore = create<ConfirmationDialogStore>((set) => ({
    isOpen: false,
    title: '',
    description: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel',
    variant: 'default',
    onConfirm: () => {},
    open: (props) =>
        set({
            isOpen: true,
            title: props.title,
            description: props.description,
            confirmText: props.confirmText || 'Confirm',
            cancelText: props.cancelText || 'Cancel',
            variant: props.variant || 'default',
            onConfirm: props.onConfirm,
        }),
    close: () => set({ isOpen: false }),
}));
