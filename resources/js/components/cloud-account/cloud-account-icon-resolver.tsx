import DigitalOceanLogo from '@/components/logos/digital-ocean';
import HetznerLogo from '@/components/logos/hetzner';
import { CloudAccount } from '@/types';
import { Cloud } from 'lucide-react';

export default function CloudAccountIconResolver({ cloudAccount }: { cloudAccount: CloudAccount }) {
    if (cloudAccount.provider === 'hetzner') {
        return <HetznerLogo />;
    }

    if (cloudAccount.provider === 'digitalocean') {
        return <DigitalOceanLogo />;
    }

    return <Cloud />;
}
