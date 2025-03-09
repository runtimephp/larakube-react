import React from 'react';
import CreateOrganizationDialog from '@/components/organization/create-organization-dialog';

/**
 * Mount all organization-related dialogs at the root level
 */
export default function OrganizationDialogs() {
    return (
        <>
            <CreateOrganizationDialog />
        </>
    );
}
