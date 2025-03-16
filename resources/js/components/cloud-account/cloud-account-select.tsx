import CloudAccountIconResolver from '@/components/cloud-account/cloud-account-icon-resolver';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { CloudAccount } from '@/types';
import { Cloud } from 'lucide-react';

interface CloudAccountSelectProps {
    cloudAccounts?: CloudAccount[] | null;
    cloudAccount?: CloudAccount | null;
    onSelect?: (cloudAccountId: string, cloudAccount?: CloudAccount) => void;
    label?: string;
    value?: string; // Add this to control the component from parent
}

export default function CloudAccountSelect({ cloudAccounts = null, onSelect, label = 'Cloud Account', value }: CloudAccountSelectProps) {
    const handleValueChange = (selectedId: string) => {
        if (onSelect && cloudAccounts) {
            const selectedAccount = cloudAccounts.find((account) => account.id.toString() === selectedId);
            onSelect(selectedId, selectedAccount);
        }
    };

    const defaultValue = value;

    if (!cloudAccounts?.length) {
        return <div>No Cloud Accounts</div>;
    }

    return (
        <div className="grid w-full items-center gap-2">
            <Label htmlFor="cloudAccount">{label}</Label>
            <Select value={defaultValue} onValueChange={handleValueChange}>
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
                    {cloudAccounts.map((account) => (
                        <SelectItem key={account.id} value={account.id.toString()}>
                            <div className="flex items-center space-x-3">
                                <CloudAccountIconResolver cloudAccount={account} />
                                <span>{account.name}</span>
                            </div>
                        </SelectItem>
                    ))}
                </SelectContent>
            </Select>
        </div>
    );
}
