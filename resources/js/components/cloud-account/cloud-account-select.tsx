import CloudAccountIconResolver from '@/components/cloud-account/cloud-account-icon-resolver';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { CloudAccount } from '@/types';
import { Cloud } from 'lucide-react';
import React from 'react';

interface CloudAccountSelectProps {
    cloudAccounts?: CloudAccount[] | null;
    cloudAccount?: CloudAccount | null;
}

export default function CloudAccountSelect({ cloudAccounts = null, cloudAccount = null }: CloudAccountSelectProps) {
    const [cloudAccountId, setCloudAccountId] = React.useState<string>(cloudAccount?.id.toString || '');

    if (!cloudAccount && cloudAccounts?.length) {
        cloudAccount = cloudAccounts[0];
    }

    return !cloudAccount ? (
        <div>No Cloud Accounts</div>
    ) : (
        <div className="grid w-full items-center gap-2">
            <Label htmlFor="cloudAccount">Cloud Account</Label>
            <Select value={cloudAccountId} onValueChange={(value: string) => setCloudAccountId(value)}>
                <SelectTrigger>
                    <div className="flex items-center space-x-3">
                        <SelectValue
                            placeholder={
                                <div className="flex items-center space-x-3">
                                    <Cloud />
                                    <span>Select a cloud account</span>
                                </div>
                            }
                        />
                    </div>
                </SelectTrigger>
                <SelectContent>
                    {cloudAccounts?.map((cloudAccount) => (
                        <SelectItem key={cloudAccount.id} value={cloudAccount.id.toString()}>
                            <div className="flex items-center space-x-3">
                                <CloudAccountIconResolver cloudAccount={cloudAccount} />
                                <span>{cloudAccount.name}</span>
                            </div>
                        </SelectItem>
                    ))}
                </SelectContent>
            </Select>
        </div>
    );
}
