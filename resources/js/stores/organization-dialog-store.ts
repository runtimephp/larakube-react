import { create } from 'zustand';

interface OrganizationDialogState {
    isOpen: boolean;
    open: () => void;
    close: () => void;
}

export const useOrganizationDialogStore = create<OrganizationDialogState>((set) => ({
    isOpen: false,
    open: () => set({ isOpen: true }),
    close: () => set({ isOpen: false })
}));
