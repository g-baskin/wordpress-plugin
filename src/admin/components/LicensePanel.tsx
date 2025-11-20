/**
 * License Panel Component
 */

import { useState } from '@wordpress/element';
import { TextControl, Button, Notice } from '@wordpress/components';
import { validateLicense } from '@shared/utils/api';
import { LicenseStatus } from '@shared/types';

interface LicensePanelProps {
	licenseStatus: LicenseStatus;
}

const LicensePanel: React.FC<LicensePanelProps> = ({ licenseStatus: initialStatus }) => {
	const [licenseKey, setLicenseKey] = useState(initialStatus.license_key || '');
	const [status, setStatus] = useState(initialStatus);
	const [validating, setValidating] = useState(false);
	const [message, setMessage] = useState<string | null>(null);

	const handleValidate = async () => {
		if (!licenseKey) {
			setMessage('Please enter a license key');
			return;
		}

		try {
			setValidating(true);
			const result = await validateLicense(licenseKey);

			if (result.success) {
				setStatus({
					active: true,
					license_key: licenseKey,
					message: result.data?.message || 'License is valid',
				});
				setMessage('License activated successfully!');
			} else {
				setMessage('License validation failed: ' + result.message);
			}
		} catch (error: any) {
			setMessage('Error: ' + (error.message || 'Unknown error'));
		} finally {
			setValidating(false);
		}
	};

	return (
		<div className="license-panel">
			{status.active && (
				<Notice status="success" isDismissible={false}>
					License is active: {status.license_key}
				</Notice>
			)}

			{!status.active && (
				<Notice status="warning" isDismissible={false}>
					No active license
				</Notice>
			)}

			<TextControl
				label="License Key"
				value={licenseKey}
				onChange={setLicenseKey}
				placeholder="Enter your license key"
				type="password"
			/>

			<div className="button-group">
				<Button
					variant="primary"
					onClick={handleValidate}
					disabled={validating}
				>
					{validating ? 'Validating...' : 'Validate License'}
				</Button>
			</div>

			{message && (
				<Notice
					status={message.includes('successfully') ? 'success' : 'error'}
					isDismissible={true}
					onRemove={() => setMessage(null)}
				>
					{message}
				</Notice>
			)}
		</div>
	);
};

export default LicensePanel;
