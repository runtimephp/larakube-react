import { CloudAccount } from '@/types';
import { create } from 'zustand';

interface CloudAccountDialogState {
    isOpen: boolean;
    cloudAccount?: CloudAccount;
    open: (cloudAccount?: CloudAccount) => void;
    close: () => void;
}

export const useCloudAccountDialogStore = create<CloudAccountDialogState>((set) => ({
    isOpen: false,
    open: (cloudAccount?: CloudAccount) => set({ isOpen: true, cloudAccount: cloudAccount }),
    close: () => set({ isOpen: false }),
}));
