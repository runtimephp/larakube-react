import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    url: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    organizations?: Organization[];
    organization?: Organization;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Organization {
    id: number;
    name: string;
    slug: string;
    created_at: string;
    updated_at: string;
}

export interface CloudAccount {
    id: number;
    provider: string;
    providerName: string;
    providerLogo: string;
    name: string;
    config: { [key: string]: unknown };
    created_at: string;
    updated_at: string;
}
