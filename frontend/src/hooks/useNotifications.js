import { useState, useEffect } from 'react';
import toast from 'react-hot-toast';

const useNotifications = () => {
  const [notifications, setNotifications] = useState([]);
  const [unreadCount, setUnreadCount] = useState(0);

  // Mock notifications - in real app, this would come from API
  useEffect(() => {
    const mockNotifications = [
      {
        id: 1,
        title: 'Nouvelle candidature',
        message: 'Une nouvelle candidature a été soumise',
        time: '5 min',
        unread: true,
        type: 'application',
        createdAt: new Date(Date.now() - 5 * 60 * 1000),
      },
      {
        id: 2,
        title: 'Candidature acceptée',
        message: 'Votre candidature à été acceptée par l\'école',
        time: '1h',
        unread: true,
        type: 'application',
        createdAt: new Date(Date.now() - 60 * 60 * 1000),
      },
      {
        id: 3,
        title: 'Message reçu',
        message: 'Vous avez reçu un nouveau message',
        time: '2h',
        unread: false,
        type: 'message',
        createdAt: new Date(Date.now() - 2 * 60 * 60 * 1000),
      },
    ];

    setNotifications(mockNotifications);
    setUnreadCount(mockNotifications.filter(n => n.unread).length);
  }, []);

  const markAsRead = (notificationId) => {
    setNotifications(prev => 
      prev.map(notification => 
        notification.id === notificationId 
          ? { ...notification, unread: false }
          : notification
      )
    );
    setUnreadCount(prev => Math.max(0, prev - 1));
  };

  const markAllAsRead = () => {
    setNotifications(prev => 
      prev.map(notification => ({ ...notification, unread: false }))
    );
    setUnreadCount(0);
  };

  const addNotification = (notification) => {
    const newNotification = {
      id: Date.now(),
      unread: true,
      createdAt: new Date(),
      ...notification,
    };

    setNotifications(prev => [newNotification, ...prev]);
    setUnreadCount(prev => prev + 1);

    // Show toast notification
    toast.success(notification.title, {
      duration: 4000,
      position: 'top-right',
    });
  };

  const removeNotification = (notificationId) => {
    const notification = notifications.find(n => n.id === notificationId);
    if (notification?.unread) {
      setUnreadCount(prev => Math.max(0, prev - 1));
    }
    setNotifications(prev => prev.filter(n => n.id !== notificationId));
  };

  const getNotificationsByType = (type) => {
    return notifications.filter(n => n.type === type);
  };

  const getRecentNotifications = (limit = 5) => {
    return notifications
      .sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt))
      .slice(0, limit);
  };

  return {
    notifications,
    unreadCount,
    markAsRead,
    markAllAsRead,
    addNotification,
    removeNotification,
    getNotificationsByType,
    getRecentNotifications,
  };
};

export default useNotifications;
