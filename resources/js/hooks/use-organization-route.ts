import { type Page } from '@inertiajs/core';
import { usePage } from '@inertiajs/react';

interface Organization {
    id: number;
    name: string;
    slug: string;
}

interface PageProps extends Page<{ organization: Organization }> {
    [key: string]: unknown;
}

declare global {
    interface Window {
        route: (name: string, params?: Record<string, any>) => string;
    }
}

export function useOrganizationRoute() {
    const { props } = usePage<PageProps>();
    const organization = props.organization as Organization;

    const route = (name: string, params: Record<string, any> = {}) => {
        return window.route(name, {
            organization: organization.slug,
            ...params,
        });
    };

    return {
        organization,
        route,
    };
}
