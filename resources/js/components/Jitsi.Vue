<template>
  <vue-jitsi-meet
    ref="jitsiRef"
    domain="meet.jit.si"
    :options="jitsiOptions"
  ></vue-jitsi-meet>
</template>

<script>
 import { JitsiMeet } from '@mycure/vue-jitsi-meet';
 export default {
    components: {
        VueJitsiMeet: JitsiMeet
    },
    computed: {
        jitsiOptions () {
            let customOptions = [
                'microphone', 'camera', 'closedcaptions', 'fullscreen',
                'fodeviceselection', 'hangup', 'chat', 'raisehand',
                'videoquality', 'filmstrip',
                'tileview'
            ];

            return {
                roomName: 'some-room-name',
                noSSL: false,
                userInfo: {
                    email: 'user@email.com',
                    displayName: 'Test',
                },
                configOverwrite: {
                    enableNoisyMicDetection: false,
                    prejoinPageEnabled: false,
                    disableAudioLevels: true,
                    disableAP: true,
                    disableAEC: true,
                    disableAGC: true,
                    disableNS: true,
                    disableHPF: true,
                },
                interfaceConfigOverwrite: {
                    SET_FILMSTRIP_ENABLED: false,
                    HIDE_INVITE_MORE_HEADER: true,
                    DISABLE_FOCUS_INDICATOR: true,
                    DISABLE_DOMINANT_SPEAKER_INDICATOR: true,
                    DISABLE_VIDEO_BACKGROUND: true,
                    SHOW_CHROME_EXTENSION_BANNER: false,
                    SHOW_JITSI_WATERMARK: false,
                    TOOLBAR_BUTTONS: customOptions
                },
                onload: this.onIFrameLoad
            };
        }
    }
 }
</script>