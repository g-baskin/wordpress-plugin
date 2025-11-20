/**
 * Admin Application
 */

import { useState, useEffect } from '@wordpress/element';
import { Card, CardBody, CardHeader, TabPanel } from '@wordpress/components';
import { getSettings, getLicenseStatus } from '@shared/utils/api';
import { PluginSettings, LicenseStatus } from '@shared/types';
import SettingsPanel from './components/SettingsPanel';
import LicensePanel from './components/LicensePanel';
import MetricsPanel from './components/MetricsPanel';
import './styles/admin.scss';

const App: React.FC = () => {
	const [settings, setSettings] = useState<PluginSettings | null>(null);
	const [licenseStatus, setLicenseStatus] = useState<LicenseStatus | null>(null);
	const [loading, setLoading] = useState(true);
	const [error, setError] = useState<string | null>(null);

	useEffect(() => {
		const loadData = async () => {
			try {
				setLoading(true);
				const [settingsData, licenseData] = await Promise.all([
					getSettings(),
					getLicenseStatus(),
				]);

				if (settingsData.success && settingsData.data) {
					setSettings(settingsData.data);
				}

				if (licenseData.success && licenseData.data) {
					setLicenseStatus(licenseData.data);
				}
			} catch (err: any) {
				setError(err.message || 'Failed to load data');
			} finally {
				setLoading(false);
			}
		};

		loadData();
	}, []);

	if (loading) {
		return <div>Loading...</div>;
	}

	const tabs = [
		{
			name: 'dashboard',
			title: 'Dashboard',
			className: 'dashboard-panel',
		},
		{
			name: 'settings',
			title: 'Settings',
			className: 'settings-panel',
		},
		{
			name: 'license',
			title: 'License',
			className: 'license-panel',
		},
	];

	return (
		<div className="wordpress-app-test-admin">
			<Card>
				<CardHeader>
					<h1>WordPress App Test</h1>
				</CardHeader>
				<CardBody>
					{error && <div className="error-notice">{error}</div>}
					<TabPanel tabs={tabs}>
						{(tab) => (
							<>
								{tab.name === 'dashboard' && (
									<MetricsPanel />
								)}
								{tab.name === 'settings' && settings && (
									<SettingsPanel settings={settings} />
								)}
								{tab.name === 'license' && licenseStatus && (
									<LicensePanel licenseStatus={licenseStatus} />
								)}
							</>
						)}
					</TabPanel>
				</CardBody>
			</Card>
		</div>
	);
};

export default App;
